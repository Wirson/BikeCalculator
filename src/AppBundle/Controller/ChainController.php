<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Chain;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

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
        $tableChain = ['front' => $chain->getFront(), 'rear' => $chain->getRear(), 'stay' => $chain->getStay(), 'result' => $chain->getResult()];
        $serialized = serialize($tableChain);
        return $this->render('AppBundle:Chain:result.html.twig', ['data' => $chain, 'serialized' => $serialized]);
    }

    /**
     * @Route("/chainPdf")
     */
    public function pdfAction(Request $request)
    {
        $chain = unserialize($request->query->get('serialized'));
        $html = $this->renderView('AppBundle:Chain:pdf.html.twig', ['data' => $chain]);

        return new Response(
            $this->get('knp_snappy.pdf')->getOutputFromHtml($html),
            200,
            array(
                'Content-Type'          => 'application/pdf',
                'Content-Disposition'   => 'attachment; filename="file.pdf"'
            )
        );
    }
}
