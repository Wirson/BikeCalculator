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

        $session = $request->getSession();
        $session->set('wheel', $wheel);

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
     * @Route("/saveWheel")
     */
    public function saveAction(Request $request)
    {
        $session = $request->getSession();
        $wheel = $session->get('wheel');
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        $wheel->setUser($user);
        $user->addWheel($wheel);
        $em->persist($wheel);
        $em->flush();
        return $this->redirectToRoute('app_wheel_show');
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
     * @Route("/showWheels")
     */
    public function showAction()
    {
        $user = $this->getUser();
        $wheels= $this
            ->getDoctrine()
            ->getRepository('AppBundle:Wheel')
            ->findBy(['user' => $user->getId()]);
        return $this->render('AppBundle:Wheel:show.html.twig', ['wheels' => $wheels]);

    }

    /**
     * @Route("/removeWheel/{id}")
     */
    public function removeAction($id)
    {
        $wheel = $this->getDoctrine()->getRepository('AppBundle:Wheel')->find($id);

        if (!$wheel) {
            throw $this->createNotFoundException('Record not found');
        }

        $em = $this->getDoctrine()->getManager();
        $em->remove($wheel);
        $em->flush();

        return $this->redirectToRoute('app_wheel_show');
    }
}
