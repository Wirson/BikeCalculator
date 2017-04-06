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

        $session = $request->getSession();
        $session->set('chain', $chain);

        $tableChain = [
            'front' => $chain->getFront(),
            'rear' => $chain->getRear(),
            'stay' => $chain->getStay(),
            'result' => $chain->getResult()
        ];
        $serialized = serialize($tableChain);
        return $this->render('AppBundle:Chain:result.html.twig', ['data' => $chain, 'serialized' => $serialized]);
    }

    /**
     * @Route("/saveChain")
     */
    public function saveAction(Request $request)
    {
        $session = $request->getSession();
        $chain = $session->get('chain');
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        $chain->setUser($user);
        $user->addChain($chain);
        $em->persist($chain);
        $em->flush();
        return $this->redirectToRoute('app_chain_show');
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

    /**
     * @Route("/showChains")
     */
    public function showAction()
    {
            $user = $this->getUser();
            //$chains = $this->getDoctrine()->getRepository('AppBundle:Chain')->find($user->ge);
        $chains = $this
            ->getDoctrine()
            ->getRepository('AppBundle:Chain')
            ->findBy(['user' => $user->getId()]);
            return $this->render('AppBundle:Chain:show.html.twig', ['chains' => $chains]);

    }

    /**
     * @Route("/removeChain/{id}")
     */
    public function removeAction($id)
    {
        $chain = $this->getDoctrine()->getRepository('AppBundle:Chain')->find($id);

        if (!$chain) {
            throw $this->createNotFoundException('Record not found');
        }

        $em = $this->getDoctrine()->getManager();
        $em->remove($chain);
        $em->flush();

        return $this->redirectToRoute('app_chain_show');
    }
}
