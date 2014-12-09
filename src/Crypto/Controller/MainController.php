<?php
/**
 * Created by PhpStorm.
 * User: thevart
 * Date: 08/12/14
 * Time: 18:14
 */

namespace Crypto\Controller;


use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Crypto\VigenereTool;

class MainController {
    public static function addRoutes($routing){
        $routing->post('/tolower', array(new self(), 'tolower'))->bind('tolower');
        $routing->post('/getCharInversion', array(new self(), 'getCharInversion'))->bind('getCharInversion');
        $routing->post('/getVigenereEncryption', array(new self(), 'getVigenereEncryption'))->bind('getVigenereEncryption');
        $routing->post('/getVigenereDecryption', array(new self(), 'getVigenereDecryption'))->bind('getVigenereDecryption');
        $routing->post('/getCipherOccurence', array(new self(), 'getCipherOccurence'))->bind('getCipherOccurence');
        $routing->post('/getCleanedCipherOccurence', array(new self(), 'getCleanedCipherOccurence'))->bind('getCleanedCipherOccurence');
        $routing->post('/getPossibleKey', array(new self(), 'getPossibleKey'))->bind('getPossibleKey');
        $routing->post('/getAllPossibleKey', array(new self(), 'getAllPossibleKey'))->bind('getAllPossibleKey');
        $routing->get('/', array(new self(), 'index'))->bind('index');
    }

    public function tolower(Application $app, Request $request){
        $text = VigenereTool::toLower($request->get('text'));
        return json_encode(array('result'=>$text));
    }

    public function getCharInversion(Application $app, Request $request){
        $result = VigenereTool::invertChar($request->get('char1'), $request->get('char2'));
        return json_encode(array('result'=>$result));
    }
    public function getVigenereEncryption(Application $app, Request $request){

        $result = VigenereTool::encryptVigenere($request->get('text1'), $request->get('text2'));
        return json_encode(array('encryptedMessage'=>$result));
    }

    public function getVigenereDecryption(Application $app, Request $request){

        $result = VigenereTool::decryptVigenere($request->get('text1'), $request->get('text2'));
        return json_encode(array('decryptedMessage'=>$result));
    }

    public function getCipherOccurence(Application $app, Request $request){

        $result = VigenereTool::getRepeatedSequence($request->get('cipher'));
        return json_encode(array('Occurences'=>$result));
    }
    public function getCleanedCipherOccurence(Application $app, Request $request){

        $result = VigenereTool::getRepeatedSequence($request->get('cipher'));
        $result = VigenereTool::cleanUselessRepetitions($result);
        return json_encode(array('Cleaned Occurences'=>$result));
    }

    public function getPossibleKey(Application $app, Request $request){

        $result = VigenereTool::getKeyFromProbableWord($request->get('cipher'), $request->get('probableWord'), $request->get('position'));
        return json_encode(array('ProbableKey'=>$result));
    }

    public function getAllPossibleKey(Application $app, Request $request){

        $result = VigenereTool::getAllPossibleKey($request->get('cipher'), $request->get('probableWord'));
        return json_encode(array('ProbableKey'=>$result));
    }

    public function index(Application $app){
        return $app['twig']->render('index.html.twig');
    }
} 