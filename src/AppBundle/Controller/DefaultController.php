<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Evaluation;
use AppBundle\Entity\produit;
use AppBundle\Form\EvaluationForm;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use AppBundle\Form\CodeBarreType;
use Symfony\Component\Validator\Constraints\DateTime;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     * @Template("index.html.twig")
     */
    public function indexAction(Request $request)
    {

        $contexte_doctrine = $this->getDoctrine()->getRepository(produit::class);
        $form = $this->createForm(CodeBarreType::class);
        $products = $contexte_doctrine->findBy(array(), array('nbConsultations' => 'DESC'), 8);
        $array_final_products = array();
        //$contexte_doctrine = $this->getDoctrine()->getManager();


        $result_eight_best = $contexte_doctrine->get_8_meilleurs();
        $eight_best = array();
        foreach ($result_eight_best as $product){
            $url = 'https://fr.openfoodfacts.org/api/v0/produit/'. $product['id_produit'] .'.json';
            $data = json_decode(file_get_contents($url), true);
            $eight_best[]= $data;
        }

        foreach ($products as $product){
            $url = 'https://fr.openfoodfacts.org/api/v0/produit/'. $product->getCodeBarre() .'.json';
            $data = json_decode(file_get_contents($url), true);
             $array_final_products[]= $data;
        }
        return [
            'form' => $form->createView(),
            'products' => $array_final_products,
            'eight_bests' => $eight_best
        ];
    }

    /**
     * @Route("/search", name="search")
     * @Template("search.html.twig")
     */
    public function searchAction(Request $request)
    {
        $form = $this->createForm(CodeBarreType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $code_barre = $data['code_barre'];

            // XXX: A faire, chercher si le produit existe, le créer en
            // base et rediriger le visiteur vers la fiche produit


            $url = 'https://fr.openfoodfacts.org/api/v0/produit/'. $code_barre .'.json';
            $data = json_decode(file_get_contents($url), true);


            if ($data['status'] == 1 && strlen($code_barre)==13 && ctype_digit($code_barre)){
                return $this->redirect($this->generateUrl('product', array('code' => $code_barre)));
            }
            return [
                'code_barre' => $code_barre
            ];

        } else {
            return $this->redirectToRoute('homepage');
        }
    }



    /**
     * @Route("/product/{code}", name="product")
     * @Template("product.html.twig")
     */
    public function productAction($code, Request $request)
    {
        $form = $this->createForm(EvaluationForm::class, ['id_produit' => $code]);
        $form->handleRequest($request);
        $contexte_doctrine = $this->getDoctrine()->getManager();
        $form_display = false;

        $url = 'https://fr.openfoodfacts.org/api/v0/produit/'. $code .'.json';
        $data = json_decode(file_get_contents($url), true);

        $la_date = new \DateTime();
        $la_date->format('Y-m-d H:i:s');



        $exists = $contexte_doctrine->getRepository(produit::class)->productExists($code);

        if($exists){
            $le_produit = $this->getDoctrine()->getRepository(produit::class)->findBy(['codeBarre' => $code])[0];
            $le_produit->setDateDerniereVue($la_date);
            $le_produit->setNbConsultations($le_produit->getNbConsultations() + 1);
            $nb_consult = $le_produit->getNbConsultations();
            $contexte_doctrine->persist($le_produit);
        }else{

            $produit_to_add = new produit();
            $produit_to_add->setCodeBarre($code);
            $produit_to_add->setDateDerniereVue($la_date);
            $produit_to_add->setNbConsultations(0);
            $nb_consult = $produit_to_add->getNbConsultations();
            $contexte_doctrine->persist($produit_to_add);
        }


        $contexte_doctrine->flush();



        if ($this->getUser() != null){

            if ($contexte_doctrine->getRepository(Evaluation::class)->not_rated($this->getUser()->getId(), $code)){

                $form_display = true;
            }
        }

        return [
            'code_barre' => $code,
            'nom' => $data['product']['product_name'],
            'quantite' => $data['product']['quantity'],
            'img' => $data['product']['image_small_url'],
            'ingredients' => $data['product']['ingredients'],
            'nb_consult' => $nb_consult,
            'average' => $contexte_doctrine->getRepository(produit::class)->average($code),
            'form' => $form->createView(),
            'form_display' => $form_display,
        ];
    }

    /**
     * @Route("/evaluate", name="evaluate")
     */
    public function evaluateAction(Request $request)
    {
        $contexte_doctrine = $this->getDoctrine()->getManager();
        $form = $this->createForm(EvaluationForm::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();



                $Eval_to_add = new Evaluation();
                $Eval_to_add->setIdUser($this->getUser()->getId());
                $Eval_to_add->setIdProduit($data['id_produit']);
                $Eval_to_add->setCommentaire($data['commentaire']);
                $Eval_to_add->setNote($data['note']);
                $contexte_doctrine->persist($Eval_to_add);
                $contexte_doctrine->flush();



            return $this->redirect($this->generateUrl('product', array('code' => $data['id_produit'])));

        } else {
            return $this->redirectToRoute('homepage');
        }
    }


}
