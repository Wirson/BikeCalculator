<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Wheel;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class WheelController extends Controller
{
    /**
     * @Route("/wheelCalculate")
     */
    public function calculateAction()
    {
        $wheel = new Wheel();

        $form = $this->createForm('AppBundle\Form\WheelType',
            $wheel,
            ['action' => $this->generateUrl('app_wheel_result')]);

        return $this->render('AppBundle:Wheel:calculate.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @Route("/wheelResult")
     */
    public function resultAction(Request $request)
    {
        $wheel = new Wheel();

        $form = $this->createForm('AppBundle\Form\WheelType', $wheel);
        $form->handleRequest($request);
        $wheel->rightSpoke();
        $wheel->leftSpoke();
        $tableWheel = [
            'centerToLeft' => $wheel->getCenterToLeft(),
            'centerToRight' => $wheel->getCenterToRight(),
            'flangeDiameter' => $wheel->getFlangeDiameter(),
            'crosses' => $wheel->getCrosses(),
            'ERD' => $wheel->getERD(),
            'holes' => $wheel->getHoles(),
            'leftSpoke' => $wheel->getResultLeft(),
            'rightSpoke' => $wheel->getResultRight()
            ];
        $serialized = serialize($tableWheel);
        return $this->render('AppBundle:Wheel:result.html.twig', ['data' => $wheel, 'serialized' => $serialized]);
    }

    /**
     * @Route("/wheelPdf")
     */
    public function pdfAction(Request $request)
    {
        $wheel = unserialize($request->query->get('serialized'));
        $html = $this->renderView('AppBundle:Wheel:pdf.html.twig', ['data' => $wheel]);

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
     *
     */
    public function saveAction()
    {

    }
}
