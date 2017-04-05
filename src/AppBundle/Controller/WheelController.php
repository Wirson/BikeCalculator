<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Wheel;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

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
        return $this->render('AppBundle:Wheel:result.html.twig', ['data' => $wheel]);
    }
}
