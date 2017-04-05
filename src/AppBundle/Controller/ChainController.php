<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Chain;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

class ChainController extends Controller
{
    /**
     * @Route("/chainCalculate")
     */
    public function calculateAction()
    {
        $chain = new Chain();

        $form = $this->createForm('AppBundle\Form\ChainType',
            $chain,
            ['action' => $this->generateUrl('app_chain_result')]);

        return $this->render('AppBundle:Chain:calculate.html.twig', ['form' => $form->createView()]);
    }


    /**
     * @Route("/chainResult")
     */
    public function resultAction(Request $request)
    {
        $chain = new Chain();

        $form = $this->createForm('AppBundle\Form\ChainType', $chain);
        $form->handleRequest($request);
        $chain->chainLength();
        return $this->render('AppBundle:Chain:result.html.twig', ['data' => $chain]);
    }
}
