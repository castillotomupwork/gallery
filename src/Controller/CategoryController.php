<?php

namespace App\Controller;

use App\Entity\Category;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class CategoryController extends AbstractController
{
    /**
     * @Route("/category/list", name="category_list", methods={"GET"})
     */
    public function list()
    {
        $categories = $this->getDoctrine()->getRepository(Category::class)->findAll();
        
        return $this->render('category/list.html.twig', ['categories' => $categories]);
    }
    
    /**
     * @Route("/category/new", name="category_new", methods={"GET", "POST"})
     */
    public function new(Request $request, ValidatorInterface $validator)
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
        
//        if ($form->isSubmitted() && $form->isValid()) {
        if ($form->isSubmitted()) {
            
            $errors = $validator->validate($category);
//            dump($errors);
//            die();
            if (count($errors) > 0) {
                $messages = [];
                foreach ($errors as $violation) {
//                     $messages[$violation->getPropertyPath()][] = $violation->getMessage();
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
//            
//            if ($form->isValid()) {
//                $category = $form->getData();
//
//                $entityManager = $this->getDoctrine()->getManager();
//                $entityManager->persist($category);
//                $entityManager->flush();
//
//                return $this->redirectToRoute('category_list');
//            }
        }
        
        return $this->render('category/new.html.twig', ['form' => $form->createView()]);
    }
    
    /**
     * @Route("/category/edit/{id}", name="category_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, $id)
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
     * @Route("/category/delete/{id}", methods={"DELETE"})
     */
    public function delete($id)
    {
        $category = $this->getDoctrine()->getRepository(Category::class)->find($id);
        
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($category);
        $entityManager->flush();
        
        $response = new Response();
        return $response->send();
    }
}