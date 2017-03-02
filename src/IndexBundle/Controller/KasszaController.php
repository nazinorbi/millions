<?php
/**
 * Created by PhpStorm.
 * User: nazi
 * Date: 2016.06.08.
 * Time: 11:24
 */

namespace IndexBundle\Controller;

use IndexBundle\_Interface\HeadCreaturInterface;
use IndexBundle\Entity\Bevetel;
use IndexBundle\Entity\Kiadas;
use IndexBundle\Entity\TranzNumber;
use IndexBundle\Entity\Zaras;
use IndexBundle\Libs\AbsBootstrap;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Response;


/**
 * Controller used to manage blog contents in the public part of the site.
 *
 * @Route("/kassza")
 * @Route("/")
 *
 */
class KasszaController extends AbsBootstrap implements HeadCreaturInterface {

    private $bevetel;
    private $egyenleg;
    private $aktEgy;
    public $date;
    private $kiadas;
    private $kuszob;
    private $waring = 'false';
    private $egyWaring = 'false';
    private $kategoria;
    private $tranz;
    private $data;

    public function run($center) {
        return $this->bootstrapRun($center);
    }
    /**
     * @Route("/", name="kassza")
     * @Method({"GET", "POST"})
     */
    public function indexAction($data = null, $ajax = false) {
        $this->sql();

        $this->date =  date('Y-m-d H:i:s');
        $this->data = $data;
       

        if($ajax) {
            if(!empty($data->checkName)) {

                $check = $this->get('login')->entryUser($data->checkName, $data->checkPassworld, $checkPass = true);
                if(!$check->passworldStatus) {
                    $this->tranzDateCalc();
                    return new Response(json_encode([
                        'data' => ['passworldStatus' => false,
                            'html_' => $this->tranz(),
                            'error' => null
                        ]] ));
                }
                else {
                    return new Response(json_encode([
                        'data' => ['passworldStatus' => true,
                            'error' => $check->error
                        ]] ));
                }
            } else if($this->tranz->sumTranz+1 <= $this->tranz->tranzNumber) {
                $this->tranzDateCalc();
               /* return new Response(json_encode([
                    'data' => ['error' => null,
                        'html_' => $this->tranz(),
                        'passworldStatus' => false
                    ]] ));*/
            }
            else {
                return new Response(json_encode([
                    'data' => ['passworldStatus' => true,
                        'error' => true
                    ]] ));
            }
        } else {
            return $this->run($this->response());
        }
    }

    public function tranz() {
        if ($this->data->type == 'Bevétel') {
            $this->bevetel();
        } else if ($this->data->type == 'Kiadás') {
            $this->kiadas();
        }
        return $this->query();
    }

    public function tranzDateCalc() {

        $date =  $this->tranz->datum;
        $today = date('Y-m-d');
        //$tomorrow = date('Y-m-d', strtotime('tomorrow'));
        $yesterday =  date('Y-m-d', strtotime('-1 day'));
        //$day_after_tomorrow = date('Y-m-d', strtotime('tomorrow + 1 day'));


        if($date == $today) {
            $sumTranz = $this->tranz->sumTranz+1;
            $this->getDoctrine()->getRepository('IndexBundle:TranzNumber')
                ->updateTranzNumber($today, $sumTranz);
        }
        else if ($date == $yesterday) {
            $sumTranz = 1;
            $this->getDoctrine()->getRepository('IndexBundle:TranzNumber')
                ->updateTranzNumber($today, $sumTranz);
        }
    }
    public function bevetel() {
        $this->bevetel = $this->getDoctrine()
            ->getRepository('IndexBundle:Bevetel')
            ->getBevetel();

        $this->insertOsszeg($this->data, 'Bevetel');
    }

    public function kiadas() {
        $this->kiadas = $this->getDoctrine()
            ->getRepository('IndexBundle:Kiadas')
            ->getKiadas();

        $this->insertOsszeg($this->data, 'Kiadas');
    }

    public function sql() {
        $this->egyenleg = $this->getDoctrine()
            ->getRepository('IndexBundle:Zaras')
            ->getZaras();

        $this->kuszob = $this->getDoctrine()
            ->getRepository('IndexBundle:Kuszob')
            ->getKuszob();

        $this->kategoria = $this->getDoctrine()
            ->getRepository('IndexBundle:Kategoria')
            ->getKat();
        $this->tranz = $this->getDoctrine()
            ->getRepository('IndexBundle:TranzNumber')
            ->getTranz();
    }

    public function insertOsszeg($data, $tbName) {
        $d = getdate();
        $data->osszeg = ($tbName == 'Kiadas') ? $data->osszeg * (-1) : $data->osszeg;

        $this->aktEgy = $this->egyenleg->osszeg + ($data->osszeg);

        if($this->aktEgy <= 0) {
            $this->egyWaring = 'true';
            return;
        }
        if($this->aktEgy < $this->kuszob) {
            $this->waring = 'true';
        } else {
            $this->waring = 'false';
        }

        if($this->dateTimeDifference($this->egyenleg->datum, $d['0'])) {
            $this->insertZaras($this->aktEgy);
        } else {
            $this->updateZaras($this->egyenleg->id, $this->aktEgy, $this->date);
        };

        if($tbName == 'Bevetel') {
            $osszeg = new Bevetel();

            $osszeg->bevetel = $data->osszeg;
            $osszeg->katId = $data->katId;
            $osszeg->post = $data->comment;
            $osszeg->datum = $this->date;

            $em = $this->getDoctrine()->getManager();
            $em->persist($osszeg);
            $em->flush();

            $this->bevetel = $this->getDoctrine()
                ->getRepository('IndexBundle:'.$tbName)
                ->getBevetel();
        }
        else {
            $osszeg = new Kiadas();

            $osszeg->kiadas = $data->osszeg;
            $osszeg->katId = $data->katId;
            $osszeg->post = $data->comment;
            $osszeg->datum = $this->date;

            $em = $this->getDoctrine()->getManager();
            $em->persist($osszeg);
            $em->flush();

            $this->bevetel = $this->getDoctrine()
                ->getRepository('IndexBundle:'.$tbName)
                ->getKiadas();
        }
    }

    public function query() {
        return $this->renderView('query.twig', [
            'aktual' => $this->aktEgy,
            'waring' => $this->waring,
            'egyWaring' => $this->egyWaring,
            'kategorias' => $this->kategoria
        ]);
    }

    public function response() {
        return $this->renderView('kassza.twig', [
            'aktual' => $this->egyenleg->osszeg,
            'kategorias' => $this->kategoria,
            'ev' => (integer)date('Y')
        ]);
    }

    public function dateTimeDifference($last, $now) {
        $ld = date_create($last, timezone_open("Europe/Oslo"));
        $lastMikro = mktime(date_format($ld, 'H'),
            date_format($ld, 'i'),
            date_format($ld, 's'),
            date_format($ld, 'n'),
            date_format($ld, 'j'),
            date_format($ld, 'Y'));

        if(floor(($lastMikro-$now)/86400) > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function insertZaras($zaras) {
        $zarasObj = new Zaras();

        $zarasObj->osszeg = $zaras;
        $zarasObj->datum = $this->date;

        $em = $this->getDoctrine()->getManager();
        $em->persist($zarasObj);
        $em->flush();
    }

    public function updateZaras($id , $zaras) {

        $this->getDoctrine()->getRepository('IndexBundle:Zaras')
            ->updateZaras($id, $zaras, $this->date);
    }
}