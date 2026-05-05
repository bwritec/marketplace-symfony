<?php

    namespace App\Service;

    use App\Repository\CategoryRepository;
    use App\Repository\LinkRepository;

    class GlobalDataService
    {
        private CategoryRepository $categoryRepository;
        private LinkRepository $linkRepository;

        public function __construct(
            CategoryRepository $categoryRepository,
            LinkRepository $linkRepository
        ) {
            $this->categoryRepository = $categoryRepository;
            $this->linkRepository = $linkRepository;
        }

        public function getGlobalData(): array
        {
            $links = $this->linkRepository->findBy([], ['id' => 'ASC']);
            $categories = $this->categoryRepository->findBy([], ['name' => 'ASC']);

            return [
                'global_links' => $links,
                'global_categories' => $this->buildCategoryTree($categories)
            ];
        }

        private function buildCategoryTree(array $categories, int $parentId = 0): array
        {
            $branch = [];

            foreach ($categories as $category) {

                // compatível com array OU entity
                $currentParent = is_array($category)
                    ? (int) ($category['parent'] ?? 0)
                    : (int) ($category->getParent()?->getId() ?? 0);

                $id = is_array($category)
                    ? (int) $category['id']
                    : (int) $category->getId();

                $name = is_array($category)
                    ? $category['name']
                    : $category->getName();

                if ($currentParent === $parentId) {

                    $children = $this->buildCategoryTree($categories, $id);

                    $branch[] = [
                        'id' => $id,
                        'name' => $name,
                        'children' => $children
                    ];
                }
            }

            return $branch;
        }
    }
