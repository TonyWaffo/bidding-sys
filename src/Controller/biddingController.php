<?php
// src/Controller/biddingController.php
namespace App\Controller;

use App\Entity\Product;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ResetType;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class biddingController extends AbstractController{
    
    /**
     * @Route("/home", name="home_page")
     */
    /*public function home(){
        
        return $this->render('bidding/home.html.twig');
    }*/
    
    public function create(Request $request){
        $result=["","",""];//create an empty layout when the page finsih loading
        $product=new Product();
        $form=$this->createFormBuilder($product)
        ->add('Name',Texttype::class,['label'=>'Nom du produit'])
        ->add('Price',Numbertype::class,['label'=>'Prix'])
        ->add('Description',Textareatype::class,['label'=>'Description'])
        ->add('Counter',Numbertype::class,['label'=>'Compteur'])
        ->add('Timer',Numbertype::class,['label'=>'Intervalle de temps'])
        ->add('Create',Submittype::class,['label'=>'Créer'])
        ->add('Reset',ResetType::class,['label'=>'Annuler'])
        ->getForm();
        
        $form->handleRequest($request);
        
        if($form->isSubmitted() && $form->isValid()){
            $product=$form->getData();
            $entityManager=$this->getDoctrine()->getManager();
            $entityManager->persist($product);
            $entityManager->flush();
            $result=[$product->getName(),$product->getPrice(),$product->getDescription()];
            return $this->render('bidding/home.html.twig',['form'=>$form->createView(),'result'=>$result]);//create a layout for the submitted article
        }
        return $this->render('bidding/home.html.twig',['form'=>$form->createView(),'result'=>$result]);
    }
}
?>