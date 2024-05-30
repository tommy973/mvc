<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class TestControllerJson extends AbstractController
{
    #[Route("/testapi/start", name: "testapi_start", methods:["GET"])]
    public function testApiStartfour(): Response
    {
        return $this->render('test4.html.twig');
    }

    // TEST UTIFRÅN EXEMPEL FRÅN DBWEBB MED DICE

    #[Route("/testapi/start", name: "testapi_post", methods: ['POST'])]
    public function initCallback(
        Request $request,
        SessionInterface $session
    ): Response {
        $uservalue = $request->request->get('uservalue');

        $session->set("uservalue", $uservalue);

        return $this->redirectToRoute('testapi_show');
    }


    // Route for twig-template
    // #[Route("/testapi/show", name: "testapi_show", methods: ['GET'])]
    // public function play(
    //     SessionInterface $session
    // ): Response {
    //     // $dicehand = $session->get("pig_dicehand");

    //     $data = [
    //         "uservalue" => $session->get("uservalue"),
    //     ];

    //     return $this->render('testshow.html.twig', $data);
    // }

    #[Route("/testapi/show", name:"testapi_show", methods:['GET'])]
    public function play(
            SessionInterface $session
    ): Response
    {

        $data = [
            'uservalue' => $session->get("uservalue"),
        ];

        $response = new Response();
        $response->setContent(json_encode($data));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    // -----------------------------------------------------------------

    // TEST MED ATT VIDAREBEFORDRA ANVÄNDAREN TILL EN NY ROUTE EFTER ATT POST SKICKATS I FORM FRÅN TEST 3
    // #[Route("/testapi/start", name: "api_start", methods:["GET"])]
    // public function apiStart(): Response
    // {
    //     return $this->render('test3.html.twig');
    // }

    // #[Route("/testapi/start", name: "api_start_post", methods:["POST"])]
    // public function apiStartPost(
    //     Request $request,
    //     SessionInterface $session
    //     ): Response
    // {

    //     $testString = $request->get('do_it');
    //     if ($testString != 'GETJsonOne') {
    //         $testString = 'Här var det annat';
    //     }
    //     $number = random_int(0, 100);
    //     $hi = 'Hello World!';


    //     $session->set("button", $testString);
    //     $session->set("message", $hi);
    //     $session->set("number", $number);


    //     return $this->redirectToRoute('api_show_info');
    // }

    // #[Route("/testapi/showinfofrompost", name:"api_show_info", methods: ['GET'])]
    // public function apiShow(
    //     SessionInterface $session
    // ): Response
    // {
    //     $data = [
    //         "button" => $session->get("button"),
    //         "number" => $session->get("number"),
    //         "message" => $session->get("message"),
    //     ];

    //     $response = new Response();
    //     $response->setContent(json_encode($data));
    //     $response->headers->set('Content-Type', 'application/json');

    //     return $response;
    // }

    // ---------------------------------------------------------------------------








    // -------------------------------------------------------------------------------------------

    // TEST MED TVÅ OLIKA ROUTES, EN FÖR TWIG-TEMPLATE OCH EN FÖR JSON-RESPONSE

    // #[Route("/testapi/startgetone", name: "api_start_get_one", methods:['GET'])]
    // public function apiStartGetOne(Request $request): Response
    // {
    //     // $testString = $request->get('do_it');
    //     $testString = $request->get('do_it');
    //     if ($testString != 'GETJsonTwo') {
    //         $testString = 'Här var det annat';
    //     }
    //     $number = random_int(0, 100);
    //     $hi = 'Hello World!';

    //     $data = [
    //         'doit' => $testString,
    //         'number' => $number,
    //         'hi' => $hi,
    //     ];
        
    //     return $this->render('test2.html.twig', $data);
    // }

    // #[Route("/testapi/startgettwo", name: "api_start_get_two", methods:['GET'])]
    // public function apiStartGetTwo(Request $request): Response
    // {
    //     $testString = $request->get('do_it');
    //     if ($testString != 'GETJsonTwo') {
    //         $testString = 'Här var det annat';
    //     }
    //     $number = random_int(0, 100);
    //     $hi = 'Hello World!';

    //     return $this->redirectToRoute('api_show_info', [
    //             'button' => $testString,
    //             'number' => $number,
    //             'message' => $hi,
    //         ]);
    // }

    // #[Route("/testapi/showinfofromgettwo/{button}/{number}/{message}", name:"api_show_info", methods: ['GET'])]
    // public function jsonDeck(
    //     Request $request,
    //     string $button,
    //     int $number,
    //     string $message,
    // ): Response
    // {
    //     $data = [
    //         'button' => $button,
    //         'number' => $number,
    //         'message' => $message,
    //     ];

    //     $response = new Response();
    //     $response->setContent(json_encode($data));
    //     $response->headers->set('Content-Type', 'application/json');

    //     return $response;
    // }


    // -------------------------------------------------------------------------------------------------




    // ------------------------------------------------------------------------------------------

    // TEST MED TVÅ OLIKA ROUTES, EN MED POST OCH EN MED GET

    // #[Route("/testapi/startgettwo/{number}", name: "api_start_get_two_post", methods:['POST'])]
    // public function apiStartGetTwoPost(
    //     Request $request,
    //     int $number,
        // string $hi
        // ): Response
    // {
        // $testString = $request->get('do_it');
        // $testString = $request->query->get('do_it');
        // $number = random_int(0, 100);
        // $hi = 'Hello World!';



        // $data = [
        //     'number' => $number,
            // 'hi' => $hi,
        // ];
        // return new JsonResponse($data);
        // return $this->render('test2.html.twig', $data);
    // }

    // #[Route("/testapi/startgettwo", name: "api_start_get_two_get", methods:['GET'])]
    // public function apiStartGetTwoGet(Request $request): Response
    // {
    //     $testString = $request->get('do_it');
    //     // $testString = $request->query->get('do_it');
    //     $number = random_int(0, 100);
    //     $hi = 'Hello World!';

    //     $data = [
    //         'doit' => $testString,
    //         'number' => $number,
    //         'hi' => $hi,
    //     ];

    //     return new JsonResponse($data);
        // return $this->redirectToRoute('api_start_get_two_post', [
        //     'number' => $number,
            // 'hi' => $hi,
        // ]);

        // $response = new JsonResponse($data);
        // $response->setEncodingOptions(
        //     $response->getEncodingOptions() | JSON_PRETTY_PRINT
        // );
        // return $response;
    // }

    // --------------------------------------------------------------------------------




    // -----------------------------------------------------------------------------------

    // TEST MED REDIRECT OCH KONTROLL VILKEN KNAPP SOM TRYCKTS PÅ

    // #[Route("/testapi/start", name: "api_start_get", methods:['GET'])]
    // public function jsontestgrej(
    //     Request $request,
    //     SessionInterface $session,
    //     // string $do_it,
    // ): Response {
    //     $testString = "TestSträng";

    //     $nextroute = $request->get('nextroute');
    //     $testrequest = $request->get('do_it');

        // if ($nextroute == 'jsontestview') {
        //     $session->set("test", $testString);
        //     $session->set("testrequest", $testrequest);
    
        //     return $this->redirectToRoute('json_test_view');
        // } else {
        //     return $this->redirectToRoute('api_start');
        // }

        // return $this->redirectToRoute('json_test_view', ['testnextroute' => $nextroute, 'testrequest' => $testrequest]);
        // print_r($testrequest);

        // if ($do_it == 'GETJson') {
        //     $session->set("test", $testString);
        //     $session->set("testrequest", $testrequest);
    
        //     return $this->redirectToRoute('json_test_view');
        // } else {
        //     return $this->redirectToRoute('api_start');
        // }

        
    // }

    // #[Route("/testapi/test", name:"jsontest", methods:['GET'])]
    // public function jsonTest(
    //     Request $request,
    //     SessionInterface $session
    // ): Response {
    //     $testString = "TestSträng";

    //     $testrequest = $request->get('do_it');

    //     $session->set("test", $testString);
    //     $session->set("testrequest", $testrequest);

    //     return $this->redirectToRoute('json_test_view');
    // }

    // #[Route("/testapi/testview", name:"json_test_view", methods:['GET'])]
    // public function jsonTestView(
    //     SessionInterface $session,
    //     string $testnextroute,
    //     string $testrequest,
    //     ): Response
    // {
    //     $data = [
    //         'test' => $testnextroute,
    //         'testrequest' => $testrequest,
    //     ];

    //     $response = new JsonResponse($data);
    //     $response->setEncodingOptions(
    //         $response->getEncodingOptions() | JSON_PRETTY_PRINT
    //     );
    //     return $response;
    // }


    
    // #[Route("/api/test", name:"jsontest", methods:['GET'])]
    // public function jsonTest(
    //     Request $request,
    //     ): Response
    // {
    //     $testString = "TestSträng";

    //     $testrequest = $request->get('do_it');

    //     $data = [
    //         'test' => $testString,
    //         'testrequest' => $testrequest,
    //     ];

    //     $response = new JsonResponse($data);
    //     $response->setEncodingOptions(
    //         $response->getEncodingOptions() | JSON_PRETTY_PRINT
    //     );
    //     return $response;
    // }

    // ---------------------------------------------------------------------------

}