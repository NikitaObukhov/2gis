<?php

namespace DoubleGis\TestBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\FixtureInterface;
use DoubleGis\TestBundle\Entity\Category;

class LoadCategoryData implements FixtureInterface
{

    public function load(ObjectManager $manager)
    {
        $categories = [
            'Еда' => [
                'Полуфабрикаты оптомПолуфабрикаты оптом',
                'Мясная продукция',
            ],
            'Автомобили' => [
                'Грузовые',
                'Легковые' => [
                    'Запчасти для подвески',
                    'Шины/Диски',
                ],
            ],
            'Спорт' => [
                'Инвентарь' => [
                    'Лыжи',
                    'Сани',
                ],
                'Питание' => [
                    'Мельдоний',
                ]
            ],
            'Справочные службы',
        ];
        $this->loadCategoriesRecursive($manager, $categories);
        $manager->flush();
    }

    protected function loadCategoriesRecursive(ObjectManager $manager, array $categories, Category $parent = null)
    {
        foreach($categories as $categoryName => $children)
        {
            if (false === is_array($children)) {
                $categoryName = $children;
            }
            $category = new Category();
            $category->setName($categoryName);
            $category->setParent($parent);
            $manager->persist($category);
            if (is_array($children)) {
                $this->loadCategoriesRecursive($manager, $children, $category);
            }
        }
    }

}