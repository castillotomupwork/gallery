<?php

namespace App\Controller;

use App\Entity\Category;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Class CategoryController
 *
 * @Route("/category")
 *
 * @package App\Controller
 */
class CategoryController extends AbstractController
{
    /**
     * @Route("/list", name="category_list", methods={"GET"})
     */
    public function listAction()
    {
        $categories = $this->getDoctrine()->getRepository(Category::class)->findAll();
        
        return $this->render('category/list.html.twig', ['categories' => $categories]);
    }
    
    /**
     * @Route("/new", name="category_new", methods={"GET", "POST"})
     */
    public function newAction(Request $request, ValidatorInterface $validator)
    {
        $category = new Category();
        
        $form =$this->createFormBuilder($category)
            ->add('category_name', TextType::class, [
                'required' => false,
                'attr' => ['class' => 'form-control']
            ])
            ->add('category_link', TextType::class, [
                'required' => false,
                'attr' => ['class' => 'form-control']
            ])
            ->add('save', SubmitType::class, [
                'label' => 'Create', 
                'attr' => ['class' => 'btn btn-primary']
            ])
            ->getForm();
        
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            
            $errors = $validator->validate($category);

            if (count($errors) > 0) {
                $messages = [];
                foreach ($errors as $violation) {
                     $messages[] = $violation->getMessage();
                }
                $this->addFlash('danger', implode('<br />', $messages));
            } else {
                $category = $form->getData();

                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($category);
                $entityManager->flush();

                return $this->redirectToRoute('category_list');
            }
        }
        
        return $this->render('category/new.html.twig', ['form' => $form->createView()]);
    }
    
    /**
     * @Route("/edit/{id}", name="category_edit", methods={"GET", "POST"})
     */
    public function editAction(Request $request, $id)
    {
        $category = new Category();
        $category = $this->getDoctrine()->getRepository(Category::class)->find($id);
        
        $form =$this->createFormBuilder($category)
            ->add('category_name', TextType::class, [
                'attr' => ['class' => 'form-control']
            ])
            ->add('save', SubmitType::class, [
                'label' => 'Update', 
                'attr' => ['class' => 'btn btn-primary']
            ])
            ->getForm();
        
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->flush();
            
            return $this->redirectToRoute('category_list');
        }
        
        return $this->render('category/edit.html.twig', ['form' => $form->createView()]);
    }
    
    /**
     * @Route("/delete/{id}", methods={"DELETE"})
     */
    public function deleteAction($id)
    {
        $category = $this->getDoctrine()->getRepository(Category::class)->find($id);
        
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($category);
        $entityManager->flush();
        
        $response = new Response();
        return $response->send();
    }
}