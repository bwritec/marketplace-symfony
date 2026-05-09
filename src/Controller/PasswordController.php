<?php

    namespace App\Controller;

    use App\Repository\UserRepository;
    use App\Repository\PasswordResetRepository;
    use Doctrine\ORM\EntityManagerInterface;
    use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
    use Symfony\Component\HttpFoundation\Request;
    use Symfony\Component\HttpFoundation\Response;
    use Symfony\Component\Mailer\MailerInterface;
    use Symfony\Component\Mime\Email;
    use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
    use Symfony\Component\Validator\Validation;
    use Symfony\Component\Validator\Constraints as Assert;


    class PasswordController extends AbstractController
    {
        public function forgot(): Response
        {
            return $this->render('system/adminlte-3.2.0/auth/forgot.html.twig', [
                'title' => 'Recuperar senha',
            ]);
        }

        public function sendResetLink(
            Request $request,
            UserRepository $userRepository,
            PasswordResetRepository $resetRepository,
            EntityManagerInterface $entityManager,
            MailerInterface $mailer
        ): Response
        {
            $validator = Validation::createValidator();

            $input = [
                'email' => $request->request->get('email'),
            ];

            $constraints = new Assert\Collection([
                'email' => [
                    new Assert\NotBlank(
                        message: 'O e-mail é obrigatório.'
                    ),

                    new Assert\Email(
                        message: 'Informe um e-mail válido.'
                    ),
                ],
            ]);

            $violations = $validator->validate($input, $constraints);

            if (count($violations) > 0)
            {
                $errors = [];

                foreach ($violations as $violation)
                {
                    $field = str_replace(['[', ']'], '', $violation->getPropertyPath());

                    $errors[$field] = $violation->getMessage();
                }

                return $this->render('system/adminlte-3.2.0/auth/forgot.html.twig', [
                    'title' => 'Recuperar senha',
                    'errors' => $errors,
                ]);
            }

            $email = $input['email'];

            $user = $userRepository->findOneBy([
                'email' => $email
            ]);

            if (!$user)
            {
                return $this->render('system/adminlte-3.2.0/auth/forgot.html.twig', [
                    'title' => 'Recuperar senha',
                    'error' => 'E-mail não encontrado.',
                ]);
            }

            $token = bin2hex(random_bytes(32));

            $reset = $resetRepository->createToken($email, $token);

            $entityManager->persist($reset);
            $entityManager->flush();

            $resetLink = $request->getSchemeAndHttpHost() . '/reset/' . $token;

            $message = (new Email())
                ->to($email)
                ->subject('Redefinição de senha')
                ->html("
                    Olá {$user->getName()},<br><br>

                    Clique no link abaixo para redefinir sua senha:<br><br>

                    <a href='{$resetLink}'>{$resetLink}</a><br><br>

                    Se você não solicitou, ignore este e-mail.
                ");

            $mailer->send($message);

            return $this->render('system/adminlte-3.2.0/auth/forgot.html.twig', [
                'title' => 'Recuperar senha',
                'success' => 'Enviamos um link para seu e-mail.',
            ]);
        }

        public function reset(
            string $token,
            PasswordResetRepository $resetRepository
        ): Response
        {
            $reset = $resetRepository->getByToken($token);

            if (!$reset)
            {
                return $this->redirect('/forgot');
            }

            return $this->render('system/adminlte-3.2.0/auth/reset.html.twig', [
                'title' => 'Redefinir senha',
                'token' => $token,
            ]);
        }

        public function updatePassword(
            Request $request,
            PasswordResetRepository $resetRepository,
            UserRepository $userRepository,
            EntityManagerInterface $entityManager,
            UserPasswordHasherInterface $passwordHasher
        ): Response
        {
            $validator = Validation::createValidator();

            $input = [
                'token' => $request->request->get('token'),
                'password' => $request->request->get('password'),
            ];

            $constraints = new Assert\Collection([
                'token' => [
                    new Assert\NotBlank(
                        message: 'Token inválido.'
                    ),
                ],

                'password' => [
                    new Assert\NotBlank(
                        message: 'A senha é obrigatória.'
                    ),

                    new Assert\Length(
                        min: 6,
                        minMessage: 'A senha deve ter no mínimo {{ limit }} caracteres.'
                    ),
                ],
            ]);

            $violations = $validator->validate($input, $constraints);

            if (count($violations) > 0)
            {
                $errors = [];

                foreach ($violations as $violation)
                {
                    $field = str_replace(['[', ']'], '', $violation->getPropertyPath());

                    $errors[$field] = $violation->getMessage();
                }

                return $this->render('system/adminlte-3.2.0/auth/reset.html.twig', [
                    'title' => 'Redefinir senha',
                    'token' => $input['token'],
                    'errors' => $errors,
                ]);
            }

            $reset = $resetRepository->getByToken($input['token']);

            if (!$reset)
            {
                return $this->redirect('/forgot');
            }

            $user = $userRepository->findOneBy([
                'email' => $reset->getEmail()
            ]);

            if (!$user)
            {
                return $this->redirect('/forgot');
            }

            $hashedPassword = $passwordHasher->hashPassword(
                $user,
                $input['password']
            );

            $user->setPassword($hashedPassword);

            $entityManager->persist($user);

            $entityManager->remove($reset);

            $entityManager->flush();

            $this->addFlash(
                'success',
                'Senha alterada com sucesso!'
            );

            return $this->redirect('/login');
        }
    }
