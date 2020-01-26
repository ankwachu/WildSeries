<?php

namespace App\Controller;

use App\Entity\Program;
use App\Form\CategoryType;
use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Category;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @Route("/category")
 */
class CategoryController extends AbstractController
{
    /**
     * @Route("/", name="category")
     * @IsGranted("ROLE_ADMIN")
     */
    public function add(Request $request): Response
    {
        $category = new Category();
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $category = $form->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($category);
            $entityManager->flush();

            return $this->redirectToRoute('category');
        }

        $categories = $this->getDoctrine()
            ->getRepository(Category::class)
            ->findAll();


        return $this->render('category/index.html.twig', [
            'form' => $form->createView(),
            'categories' => $categories,
        ]);
    }

    public function allCategories(CategoryRepository $categoryRepository)
    {
        $categories = $categoryRepository->findBy(
            [],
            ['name' => 'ASC'],
            20
        );

        return $this->render('_categories.html.twig', [
            'categories' => $categories,
        ]);
    }

    /**
     * @Route("/{id}", name="category_show", methods={"GET"})
     * @param Category $category
     * @return Response
     */
    public function show(Category $category): Response
    {
        return $this->render('category/show.html.twig', [
            'category' => $category,

        ]);
    }
}
