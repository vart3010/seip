<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Pequiven\MasterBundle\DataFixtures;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Pequiven\MasterBundle\Entity\Personal;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;

/**
 * Description of PersonalFixture
 *
 * @author matias
 */
class PersonalFixture extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface {
    //put your code here
    protected $container;
    public function load(ObjectManager $manager){

//        $personal = new Personal();
//        $personal->setCedula('18076543');
//        $personal->setNomPersonal('SANCHEZ L, TANY C.');
//        $personal->setNumPersonal('10022282');
//        $personal->setEnabled(true);
//        $personal->setCargo($this->getReference('Cargo-01'));
//        $this->addReference('Personal-10022282', $personal);
//            $manager->persist($personal);
//            
//        $personal = new Personal();
//        $personal->setCedula('7013169');
//        $personal->setNomPersonal('OLIVO Z , GEORGINA');
//        $personal->setNumPersonal('10019081');
//        $personal->setEnabled(true);
//        $personal->setCargo($this->getReference('Cargo-2158'));
//        $this->addReference('Personal-18076543',$personal);
//            $manager->persist($personal);
//            
//        $personal = new Personal();
//        $personal->setCedula('9688155');
//        $personal->setNomPersonal('ESCALONA O , VICTOR J');
//        $personal->setNumPersonal('10016012');
//        $personal->setEnabled(true);
//        $personal->setCargo($this->getReference('Cargo-2038'));
//        $this->addReference('Personal-9688155',$personal);
//            $manager->persist($personal);
//        
//        $personal = new Personal();
//        $personal->setCedula('8242913');
//        $personal->setNomPersonal('GUARARIMA F , ADILIA M');
//        $personal->setNumPersonal('10003393');
//        $personal->setEnabled(true);
//        $personal->setCargo($this->getReference('Cargo-2160'));
//        $this->addReference('Personal-8242913',$personal);
//            $manager->persist($personal);

        
        //Personal proyecto navay 
        // gerencia 65

        $personal = new Personal();
        $personal->setCedula('10173339');
        $personal->setNomPersonal('CONTRERAS P , JUAN C');
        $personal->setNumPersonal('10021166');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1753'));
        $this->addReference('Personal-10021166', $personal);
            $manager->persist($personal);

        // gerencia 66

        $personal = new Personal();
        $personal->setCedula('16122770');
        $personal->setNomPersonal('MORA D , JUAN G');
        $personal->setNumPersonal('10020597');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1754'));
        $this->addReference('Personal-10020597', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('11192550');
        $personal->setNomPersonal('SILVA  Q. , JOSE  A.');
        $personal->setNumPersonal('10020460');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1754'));
        $this->addReference('Personal-10020460', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('4524360');
        $personal->setNomPersonal('ROMERO , DAISY J.');
        $personal->setNumPersonal('10017157');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1754'));
        $this->addReference('Personal-10017157', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('9208252');
        $personal->setNomPersonal('ROJAS V , NELLY M');
        $personal->setNumPersonal('10020596');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1755'));
        $this->addReference('Personal-10020596', $personal);
            $manager->persist($personal);


        $personal = new Personal();
        $personal->setCedula('9125113');
        $personal->setNomPersonal('LABRADOR M , NANCY M');
        $personal->setNumPersonal('10021438');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1756'));
        $this->addReference('Personal-10021438', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('5512304');
        $personal->setNomPersonal('GAVIDIA C , LUIS J');
        $personal->setNumPersonal('10019511');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1757'));
        $this->addReference('Personal-10019511', $personal);
            $manager->persist($personal);


        $personal = new Personal();
        $personal->setCedula('5660706');
        $personal->setNomPersonal('QUINTERO S , FREDDY O');
        $personal->setNumPersonal('10012577');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1758'));
        $this->addReference('Personal-10012577', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('13145100');
        $personal->setNomPersonal('VANEGAS C , CHEO P');
        $personal->setNumPersonal('10021207');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1759'));
        $this->addReference('Personal-10021207', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('13305118');
        $personal->setNomPersonal('DUQUE G , ALEIDY Y');
        $personal->setNumPersonal('10021170');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1760'));
        $this->addReference('Personal-10021170', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('13709290');
        $personal->setNomPersonal('MARTINEZ M , DANIEL E');
        $personal->setNumPersonal('10021555');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1760'));
        $this->addReference('Personal-10021555', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('12232021');
        $personal->setNomPersonal('GUERRA CH , IRIS M');
        $personal->setNumPersonal('10020790');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1761'));
        $this->addReference('Personal-10020790', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('12349027');
        $personal->setNomPersonal('GUILLEN G , YUBISAY DEL C');
        $personal->setNumPersonal('10021336');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1762'));
        $this->addReference('Personal-10021336', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('14384602');
        $personal->setNomPersonal('ROMERO G , MARYORI C');
        $personal->setNumPersonal('10021553');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1763'));
        $this->addReference('Personal-10021553', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('12813323');
        $personal->setNomPersonal('ROSALES C , JEAN C');
        $personal->setNumPersonal('10021550');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1764'));
        $this->addReference('Personal-10021550', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('4210554');
        $personal->setNomPersonal('GONZALEZ C , RAFAEL E');
        $personal->setNumPersonal('10021439');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1765'));
        $this->addReference('Personal-10021439', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('14148104');
        $personal->setNomPersonal('CASTRO L , MARCELO E');
        $personal->setNumPersonal('10020798');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1766'));
        $this->addReference('Personal-10020798', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('15353718');
        $personal->setNomPersonal('DAVILA CH , YENITH Y');
        $personal->setNumPersonal('10021433');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1767'));
        $this->addReference('Personal-10021433', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('8858075');
        $personal->setNomPersonal('GASCON C , WILLIAN E');
        $personal->setNumPersonal('10020894');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1767'));
        $this->addReference('Personal-10020894', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('8107342');
        $personal->setNomPersonal('OROZCO M , HAROLD J');
        $personal->setNumPersonal('10021167');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1768'));
        $this->addReference('Personal-10021167', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('17285657');
        $personal->setNomPersonal('MACIAS P , YENNYFER');
        $personal->setNumPersonal('10020680');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1769'));
        $this->addReference('Personal-10020680', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('15988267');
        $personal->setNomPersonal('QUINTANA C , DANIEL E');
        $personal->setNumPersonal('10019942');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1770'));
        $this->addReference('Personal-10019942', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('17107820');
        $personal->setNomPersonal('NAVAS Z , JESUS E');
        $personal->setNumPersonal('10021576');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1770'));
        $this->addReference('Personal-10021576', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('17678535');
        $personal->setNomPersonal('MORA CH , OMAR D');
        $personal->setNumPersonal('10020323');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1770'));
        $this->addReference('Personal-10020323', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('17208905');
        $personal->setNomPersonal('DELGADO C , RAUL E');
        $personal->setNumPersonal('10019940');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1771'));
        $this->addReference('Personal-10019940', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('13211948');
        $personal->setNomPersonal('CASTRO V , EDGAR A');
        $personal->setNumPersonal('10021208');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1772'));
        $this->addReference('Personal-10021208', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('10263949');
        $personal->setNomPersonal('BRICEÑO A , BRIGITTE G');
        $personal->setNumPersonal('10020057');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1773'));
        $this->addReference('Personal-10020057', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('12462147');
        $personal->setNomPersonal('AGUILAR M , DIORLAND J');
        $personal->setNumPersonal('10020896');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1774'));
        $this->addReference('Personal-10020896', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('10147029');
        $personal->setNomPersonal('ZAMBRANO CH , JUAN A');
        $personal->setNumPersonal('10021169');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1775'));
        $this->addReference('Personal-10021169', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('14417093');
        $personal->setNomPersonal('SANCHEZ B. , GIHOVER S');
        $personal->setNumPersonal('10020318');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1776'));
        $this->addReference('Personal-10020318', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('8030205');
        $personal->setNomPersonal('DUGARTE L , LUZ M');
        $personal->setNumPersonal('10020502');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1777'));
        $this->addReference('Personal-10020502', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('5327689');
        $personal->setNomPersonal('CAÑAS A , MILAGROS DE LA T');
        $personal->setNumPersonal('10020898');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1778'));
        $this->addReference('Personal-10020898', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('10156382');
        $personal->setNomPersonal('CHACON M , VICTOR L');
        $personal->setNumPersonal('10017779');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1779'));
        $this->addReference('Personal-10017779', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('15235453');
        $personal->setNomPersonal('BELANDRIA M , LISETH T');
        $personal->setNumPersonal('10019932');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1780'));
        $this->addReference('Personal-10019932', $personal);
            $manager->persist($personal);

        // gerencia 67

        $personal = new Personal();
        $personal->setCedula('9213190');
        $personal->setNomPersonal('LOPEZ G , YOLEIDA');
        $personal->setNumPersonal('10021595');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1781'));
        $this->addReference('Personal-10021595', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('5028073');
        $personal->setNomPersonal('PARADA C , LAUDELINO');
        $personal->setNumPersonal('10020884');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1782'));
        $this->addReference('Personal-10020884', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('15927635');
        $personal->setNomPersonal('ARCILA D , ISABEL V');
        $personal->setNumPersonal('10021152');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1783'));
        $this->addReference('Personal-10021152', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('12516445');
        $personal->setNomPersonal('PEREZ B , LESLY Y');
        $personal->setNumPersonal('10020899');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1784'));
        $this->addReference('Personal-10020899', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('14100121');
        $personal->setNomPersonal('TORRES V , LEUSI N');
        $personal->setNumPersonal('10019513');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1785'));
        $this->addReference('Personal-10019513', $personal);
            $manager->persist($personal);

        // proyecto paraguana
        // gerencia 68

        $personal = new Personal();
        $personal->setCedula('15140711');
        $personal->setNomPersonal('CEQUEA CH , LUIS D');
        $personal->setNumPersonal('10021641');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1786'));
        $this->addReference('Personal-10021641', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('9518191');
        $personal->setNomPersonal('PETIT L , ADA M');
        $personal->setNumPersonal('10021583');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1787'));
        $this->addReference('Personal-10021583', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('14404164');
        $personal->setNomPersonal('SANCHEZ M , EDGAR A');
        $personal->setNumPersonal('10021789');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1788'));
        $this->addReference('Personal-10021789', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('16196915');
        $personal->setNomPersonal('CASTILLO L , MARIA J');
        $personal->setNumPersonal('10021740');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1789'));
        $this->addReference('Personal-10021740', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('14793446');
        $personal->setNomPersonal('TOYO A , ANEIKA K');
        $personal->setNumPersonal('10021787');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1790'));
        $this->addReference('Personal-10021787', $personal);
            $manager->persist($personal);

        // gerencia 69 

        $personal = new Personal();
        $personal->setCedula('13551499');
        $personal->setNomPersonal('ROMERO S , DOLANGEE C');
        $personal->setNumPersonal('10016423');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1791'));
        $this->addReference('Personal-10016423', $personal);
            $manager->persist($personal);

        // sede Valencia
        // gerencia 70

        $personal = new Personal();
        $personal->setCedula('17129508');
        $personal->setNomPersonal('PAREDES Q , ROBERTO J');
        $personal->setNumPersonal('10022290');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1792'));
        $this->addReference('Personal-10022290', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('15565869');
        $personal->setNomPersonal('ESPERANZA V , ANDREINA T');
        $personal->setNumPersonal('10020403');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1792'));
        $this->addReference('Personal-10020403', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('11602050');
        $personal->setNomPersonal('HADID F , YORYETT');
        $personal->setNumPersonal('10020452');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1792'));
        $this->addReference('Personal-10020452', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('3182426');
        $personal->setNomPersonal('VAAMONDE C , JORGE O');
        $personal->setNumPersonal('10015698');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1792'));
        $this->addReference('Personal-10015698', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('4561445');
        $personal->setNomPersonal('HERNANDEZ  DE H , BELEN M');
        $personal->setNumPersonal('10021824');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1792'));
        $this->addReference('Personal-10021824', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('13083682');
        $personal->setNomPersonal('RIOS C , HECTOR');
        $personal->setNumPersonal('10021364');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1792'));
        $this->addReference('Personal-10021364', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('13666922');
        $personal->setNomPersonal('GUEVARA G , MARIELA  M');
        $personal->setNumPersonal('10019918');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1792'));
        $this->addReference('Personal-10019918', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('11735728');
        $personal->setNomPersonal('DUQUE CUEVAS , LUIS ENRIQUE');
        $personal->setNumPersonal('10016362');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1792'));
        $this->addReference('Personal-10016362', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('14045602');
        $personal->setNomPersonal('OSAL U , FRANCIS B');
        $personal->setNumPersonal('10017771');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1792'));
        $this->addReference('Personal-10017771', $personal);
            $manager->persist($personal);


        $personal = new Personal();
        $personal->setCedula('14764332');
        $personal->setNomPersonal('FLORES  L , CAROLINA DEL V');
        $personal->setNumPersonal('10021043');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1793'));
        $this->addReference('Personal-10021043', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('14821569');
        $personal->setNomPersonal('SANCHEZ G , FABIAN A');
        $personal->setNumPersonal('10022594');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1794'));
        $this->addReference('Personal-10022594', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('15421178');
        $personal->setNomPersonal('JAIMES U , ERUBY A');
        $personal->setNumPersonal('10015626');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1795'));
        $this->addReference('Personal-10015626', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('3896275');
        $personal->setNomPersonal('SILVA R , SAUL O');
        $personal->setNumPersonal('10018451');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1796'));
        $this->addReference('Personal-10018451', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('13147535');
        $personal->setNomPersonal('BARRIENTOS C , VICTOR D');
        $personal->setNumPersonal('10016040');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1797'));
        $this->addReference('Personal-10016040', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('7766548');
        $personal->setNomPersonal('BENAVIDES Q , BELKYS C');
        $personal->setNumPersonal('10023174');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1798'));
        $this->addReference('Personal-10023174', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('11989708');
        $personal->setNomPersonal('CORONADO C , EDDY B');
        $personal->setNumPersonal('10025912');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1799'));
        $this->addReference('Personal-10025912', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('5426114');
        $personal->setNomPersonal('LUNA R , GILBERTO A');
        $personal->setNumPersonal('10020315');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1800'));
        $this->addReference('Personal-10020315', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('8603805');
        $personal->setNomPersonal('MESA R , JEANETTE DEL V');
        $personal->setNumPersonal('10019259');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1801'));
        $this->addReference('Personal-10019259', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('17981981');
        $personal->setNomPersonal('PALMA P , CARENIS V');
        $personal->setNumPersonal('10017244');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1801'));
        $this->addReference('Personal-10017244', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('14972435');
        $personal->setNomPersonal('BORGES S , NAYIB S');
        $personal->setNumPersonal('10016758');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1802'));
        $this->addReference('Personal-10016758', $personal);
            $manager->persist($personal);

        // gerencia 71

        $personal = new Personal();
        $personal->setCedula('9877459');
        $personal->setNomPersonal('MERCADO M , CARMEN M');
        $personal->setNumPersonal('10021001');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1803'));
        $this->addReference('Personal-10021001', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('17390347');
        $personal->setNomPersonal('DIAZ T , MADELEINE N');
        $personal->setNumPersonal('10021834');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1804'));
        $this->addReference('Personal-10021834', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('14041434');
        $personal->setNomPersonal('ZAMBRANO Z , MARIELY A');
        $personal->setNumPersonal('10019136');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1804'));
        $this->addReference('Personal-10019136', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('11274663');
        $personal->setNomPersonal('GONZALEZ G , RAFAEL R');
        $personal->setNumPersonal('10021247');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1804'));
        $this->addReference('Personal-10021247', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('10160439');
        $personal->setNomPersonal('CHAVEZ M , ANGELA E');
        $personal->setNumPersonal('10020893');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1804'));
        $this->addReference('Personal-10020893', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('5657292');
        $personal->setNomPersonal('CHACON C , LEYDA Z');
        $personal->setNumPersonal('10021205');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1804'));
        $this->addReference('Personal-10021205', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('16329271');
        $personal->setNomPersonal('RODRIGUEZ M , DIANA C');
        $personal->setNumPersonal('10020445');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1804'));
        $this->addReference('Personal-10020445', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('11199041');
        $personal->setNomPersonal('MIJARES B , KATIUSKA E');
        $personal->setNumPersonal('10015810');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1804'));
        $this->addReference('Personal-10015810', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('14915486');
        $personal->setNomPersonal('GALICIA J , DANI J');
        $personal->setNumPersonal('10021191');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1804'));
        $this->addReference('Personal-10021191', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('16404725');
        $personal->setNomPersonal('ALVAREZ O MARIA E');
        $personal->setNumPersonal('10020429');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1804'));
        $this->addReference('Personal-10020429', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('13973917');
        $personal->setNomPersonal('SALGADO T , MARLYM T');
        $personal->setNumPersonal('10016087');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1804'));
        $this->addReference('Personal-10016087', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('15981780');
        $personal->setNomPersonal('PADILLA U , ALEXANDER A');
        $personal->setNumPersonal('10021640');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1804'));
        $this->addReference('Personal-10021640', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('12789421');
        $personal->setNomPersonal('MORALES M , MARIANELA');
        $personal->setNumPersonal('10021712');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1804'));
        $this->addReference('Personal-10021712', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('17310749');
        $personal->setNomPersonal('GONZALEZ D , ROSSI E');
        $personal->setNumPersonal('10021353');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1804'));
        $this->addReference('Personal-10021353', $personal);
            $manager->persist($personal);


        $personal = new Personal();
        $personal->setCedula('14210947');
        $personal->setNomPersonal('CAMEJO M , JUAN  J');
        $personal->setNumPersonal('10021892');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1805'));
        $this->addReference('Personal-10021892', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('10226471');
        $personal->setNomPersonal('MARTINEZ , AZALEA DE M');
        $personal->setNumPersonal('10024233');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1806'));
        $this->addReference('Personal-10024233', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('14558838');
        $personal->setNomPersonal('ANGEL Q , LUIS A');
        $personal->setNumPersonal('10021507');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1806'));
        $this->addReference('Personal-10021507', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('7172010');
        $personal->setNomPersonal('ESPINOZA P , JOSE I');
        $personal->setNumPersonal('10023839');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1807'));
        $this->addReference('Personal-10023839', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('14302405');
        $personal->setNomPersonal('CASADIEGO B , OSMAIGUALIDA');
        $personal->setNumPersonal('10023838');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1807'));
        $this->addReference('Personal-10023838', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('7299507');
        $personal->setNomPersonal('REINA , LUIS R');
        $personal->setNumPersonal('10017014');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1807'));
        $this->addReference('Personal-10017014', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('16660139');
        $personal->setNomPersonal('RANGEL N , YESSICA M');
        $personal->setNumPersonal('10017223');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1807'));
        $this->addReference('Personal-10017223', $personal);
            $manager->persist($personal);


        $personal = new Personal();
        $personal->setCedula('15007900');
        $personal->setNomPersonal('GAMBOA P , LUIS C');
        $personal->setNumPersonal('10023581');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1808'));
        $this->addReference('Personal-10023581', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('14239311');
        $personal->setNomPersonal('SOJO F , LUIS A');
        $personal->setNumPersonal('10019841');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1808'));
        $this->addReference('Personal-10019841', $personal);
            $manager->persist($personal);


        $personal = new Personal();
        $personal->setCedula('14038120');
        $personal->setNomPersonal('RIVERO D , ZULYNEL M');
        $personal->setNumPersonal('10021897');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1809'));
        $this->addReference('Personal-10021897', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('17173958');
        $personal->setNomPersonal('ROJAS P , OSWALDO F');
        $personal->setNumPersonal('10023846');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1810'));
        $this->addReference('Personal-10023846', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('5534319');
        $personal->setNomPersonal('MARTINEZ C , EDGAR A');
        $personal->setNumPersonal('10021637');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1811'));
        $this->addReference('Personal-10021637', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('16785117');
        $personal->setNomPersonal('PADILLA T , ROSSANY H');
        $personal->setNumPersonal('10019392');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1811'));
        $this->addReference('Personal-10019392', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('12996510');
        $personal->setNomPersonal('OJEDA M , MARJORI M');
        $personal->setNumPersonal('10018915');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1812'));
        $this->addReference('Personal-10018915', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('10169118');
        $personal->setNomPersonal('UZCATEGUI Z , GLENDA A');
        $personal->setNumPersonal('10021589');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1813'));
        $this->addReference('Personal-10021589', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('11308135');
        $personal->setNomPersonal('LUNA D , GABRIELA E');
        $personal->setNumPersonal('10012981');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1814'));
        $this->addReference('Personal-10012981', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('8627850');
        $personal->setNomPersonal('BOLIVAR M , TIVISAY C');
        $personal->setNumPersonal('10019517');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1815'));
        $this->addReference('Personal-10019517', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('15990272');
        $personal->setNomPersonal('NUÑEZ R , DARKIS C');
        $personal->setNumPersonal('10020895');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1816'));
        $this->addReference('Personal-10020895', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('6079451');
        $personal->setNomPersonal('PEREZ R , JOSE R');
        $personal->setNumPersonal('10017242');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1817'));
        $this->addReference('Personal-10017242', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('13945050');
        $personal->setNomPersonal('MULLER A , LUIS G');
        $personal->setNumPersonal('10020588');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1818'));
        $this->addReference('Personal-10020588', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('10322680');
        $personal->setNomPersonal('TOLEDO M , ARMANDO J');
        $personal->setNumPersonal('10017562');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1819'));
        $this->addReference('Personal-10017562', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('11960471');
        $personal->setNomPersonal('MOLINA G , WALTER O');
        $personal->setNumPersonal('10019375');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1820'));
        $this->addReference('Personal-10019375', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('13561617');
        $personal->setNomPersonal('BONIA M , YIMY E');
        $personal->setNumPersonal('10016841');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1821'));
        $this->addReference('Personal-10016841', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('9328008');
        $personal->setNomPersonal('BRICEÑO R , BLADIMIR A');
        $personal->setNumPersonal('10021844');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1822'));
        $this->addReference('Personal-10021844', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('2574335');
        $personal->setNomPersonal('ORDOÑEZ M , JOAQUIN');
        $personal->setNumPersonal('10019668');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1823'));
        $this->addReference('Personal-10019668', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('4100985');
        $personal->setNomPersonal('PARRA M , JOSE M');
        $personal->setNumPersonal('10019112');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1824'));
        $this->addReference('Personal-10019112', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('11599690');
        $personal->setNomPersonal('LEON  V , MANUEL  H');
        $personal->setNumPersonal('10021893');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1825'));
        $this->addReference('Personal-10021893', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('13548292');
        $personal->setNomPersonal('PARRA , AMILCAR S');
        $personal->setNumPersonal('10021894');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1825'));
        $this->addReference('Personal-10021894', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('5276290');
        $personal->setNomPersonal('SORIANO  L , ROBERTO  E');
        $personal->setNumPersonal('10021895');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1825'));
        $this->addReference('Personal-10021895', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('12316607');
        $personal->setNomPersonal('SILVA C , HUMBERTO J');
        $personal->setNumPersonal('10021896');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1825'));
        $this->addReference('Personal-10021896', $personal);
            $manager->persist($personal);



        $personal = new Personal();
        $personal->setCedula('10562790');
        $personal->setNomPersonal('DIAZ V , YOCELIN R');
        $personal->setNumPersonal('10021573');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1826'));
        $this->addReference('Personal-10021573', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('14970394');
        $personal->setNomPersonal('MORALES , ISABEL M');
        $personal->setNumPersonal('10020086');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1826'));
        $this->addReference('Personal-10020086', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('10564592');
        $personal->setNomPersonal('MARIN A , MIGUEL A');
        $personal->setNumPersonal('10020570');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1827'));
        $this->addReference('Personal-10020570', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('10357447');
        $personal->setNomPersonal('GOMEZ O , ADRIANO G');
        $personal->setNumPersonal('10017249');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1828'));
        $this->addReference('Personal-10017249', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('9731082');
        $personal->setNomPersonal('CALDERON P , JAIRO A');
        $personal->setNumPersonal('10017156');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1829'));
        $this->addReference('Personal-10017156', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('4483606');
        $personal->setNomPersonal('MARTURET Y , MARIA L');
        $personal->setNumPersonal('10021785');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1830'));
        $this->addReference('Personal-10021785', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('12854813');
        $personal->setNomPersonal('CARTA M , GUILLERMO J');
        $personal->setNumPersonal('10021203');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1831'));
        $this->addReference('Personal-10021203', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('9874039');
        $personal->setNomPersonal('LUNA , YONIS E');
        $personal->setNumPersonal('10016860');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1832'));
        $this->addReference('Personal-10016860', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('4529837');
        $personal->setNomPersonal('MENDT H. , HANS');
        $personal->setNumPersonal('10015986');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1833'));
        $this->addReference('Personal-10015986', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('6463854');
        $personal->setNomPersonal('VEGAS G , YHONIS E');
        $personal->setNumPersonal('10019059');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1834'));
        $this->addReference('Personal-10019059', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('11510507');
        $personal->setNomPersonal('LABORIT C , JOSÉ G');
        $personal->setNumPersonal('10019923');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1835'));
        $this->addReference('Personal-10019923', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('12029310');
        $personal->setNomPersonal('VILLEGAS M , YIBELKYS M');
        $personal->setNumPersonal('10021192');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1836'));
        $this->addReference('Personal-10021192', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('13747878');
        $personal->setNomPersonal('ALBESIANO B , YARUBI');
        $personal->setNumPersonal('10021699');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1837'));
        $this->addReference('Personal-10021699', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('11794041');
        $personal->setNomPersonal('HERNANDEZ B , ANGEL J');
        $personal->setNumPersonal('10021569');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1837'));
        $this->addReference('Personal-10021569', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('8131809');
        $personal->setNomPersonal('PAIVA M. , LUIS A');
        $personal->setNumPersonal('10020574');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1838'));
        $this->addReference('Personal-10020574', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('16475064');
        $personal->setNomPersonal('CATIRE B , YENISSE C');
        $personal->setNumPersonal('10021147');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1839'));
        $this->addReference('Personal-10021147', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('10229770');
        $personal->setNomPersonal('LATTUF B , EDGAR R');
        $personal->setNumPersonal('10021425');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1840'));
        $this->addReference('Personal-10021425', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('10051729');
        $personal->setNomPersonal('PERAZA M , WILER R');
        $personal->setNumPersonal('10020571');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1841'));
        $this->addReference('Personal-10020571', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('10725317');
        $personal->setNomPersonal('TOVAR T , MARCOS A');
        $personal->setNumPersonal('10020567');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1841'));
        $this->addReference('Personal-10020567', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('15383425');
        $personal->setNomPersonal('MORENO G , MIGUEL A');
        $personal->setNumPersonal('10021138');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1842'));
        $this->addReference('Personal-10021138', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('11524245');
        $personal->setNomPersonal('CEBALLOS J , JESUS E');
        $personal->setNumPersonal('10017546');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1843'));
        $this->addReference('Personal-10017546', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('6354374');
        $personal->setNomPersonal('LARA P , NORIS R');
        $personal->setNumPersonal('10020092');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1844'));
        $this->addReference('Personal-10020092', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('5494439');
        $personal->setNomPersonal('DIAZ U , FREDDY J');
        $personal->setNumPersonal('10020799');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1845'));
        $this->addReference('Personal-10020799', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('10736800');
        $personal->setNomPersonal('MONTERO O , JORGE L');
        $personal->setNumPersonal('10016088');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1846'));
        $this->addReference('Personal-10016088', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('7310689');
        $personal->setNomPersonal('RUBINO B , GOFFREDO A');
        $personal->setNumPersonal('10016124');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1847'));
        $this->addReference('Personal-10016124', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('4100901');
        $personal->setNomPersonal('HERNANDEZ , VICTOR J');
        $personal->setNumPersonal('10001139');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1848'));
        $this->addReference('Personal-10001139', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('4793283');
        $personal->setNomPersonal('BOULANGER L , JOSE A');
        $personal->setNumPersonal('10001757');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1849'));
        $this->addReference('Personal-10001757', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('10732437');
        $personal->setNomPersonal('MONQUE  C , CARMEN D.');
        $personal->setNumPersonal('10020858');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1850'));
        $this->addReference('Personal-10020858', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('10034753');
        $personal->setNomPersonal('PACHECO R , YUGLEDYS M');
        $personal->setNumPersonal('10019473');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1851'));
        $this->addReference('Personal-10019473', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('14382778');
        $personal->setNomPersonal('MORILLO  R. , ANA  M.');
        $personal->setNumPersonal('10020560');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1852'));
        $this->addReference('Personal-10020560', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('17987970');
        $personal->setNomPersonal('MOLINA C , JOSE A');
        $personal->setNumPersonal('10023063');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1853'));
        $this->addReference('Personal-10023063', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('16791397');
        $personal->setNomPersonal('JUAREZ M , FRANCISCO J');
        $personal->setNumPersonal('10021140');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1853'));
        $this->addReference('Personal-10021140', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('12552990');
        $personal->setNomPersonal('MORENO R , KENY S');
        $personal->setNumPersonal('10021150');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1853'));
        $this->addReference('Personal-10021150', $personal);
            $manager->persist($personal);


        $personal = new Personal();
        $personal->setCedula('9989565');
        $personal->setNomPersonal('EL TROUDI D , UASIM A');
        $personal->setNumPersonal('10021609');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1854'));
        $this->addReference('Personal-10021609', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('16446046');
        $personal->setNomPersonal('CORTESE DE C , MARIA A');
        $personal->setNumPersonal('10020888');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1855'));
        $this->addReference('Personal-10020888', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('9609271');
        $personal->setNomPersonal('AGUILAR DE B , CARMEN L');
        $personal->setNumPersonal('10018714');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1855'));
        $this->addReference('Personal-10018714', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('14264685');
        $personal->setNomPersonal('AYALA S , JOSE D');
        $personal->setNumPersonal('10021195');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1855'));
        $this->addReference('Personal-10021195', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('17738031');
        $personal->setNomPersonal('DIAZ R , LUIS V');
        $personal->setNumPersonal('10020461');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1855'));
        $this->addReference('Personal-10020461', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('14919807');
        $personal->setNomPersonal('BOQUETT S , KEVIN R');
        $personal->setNumPersonal('10020672');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1855'));
        $this->addReference('Personal-10020672', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('16611267');
        $personal->setNomPersonal('RINCON CH , LEIDY C');
        $personal->setNumPersonal('10021168');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1855'));
        $this->addReference('Personal-10021168', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('14417112');
        $personal->setNomPersonal('CALDERON B , ELDA M');
        $personal->setNumPersonal('10021165');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1855'));
        $this->addReference('Personal-10021165', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('15640538');
        $personal->setNomPersonal('JAIMES O , MAORDY A');
        $personal->setNumPersonal('10021204');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1855'));
        $this->addReference('Personal-10021204', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('15085964');
        $personal->setNomPersonal('GARCIA M , SONNY D');
        $personal->setNumPersonal('10020667');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1855'));
        $this->addReference('Personal-10020667', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('14368576');
        $personal->setNomPersonal('LEAL M , LEONARD S');
        $personal->setNumPersonal('10021590');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1855'));
        $this->addReference('Personal-10021590', $personal);
            $manager->persist($personal);


        $personal = new Personal();
        $personal->setCedula('15518066');
        $personal->setNomPersonal('PENSO M , MARIA A');
        $personal->setNumPersonal('10021984');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1856'));
        $this->addReference('Personal-10021984', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('16692555');
        $personal->setNomPersonal('TACHAU D , ALEJANDRINA T');
        $personal->setNumPersonal('10021467');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1856'));
        $this->addReference('Personal-10021467', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('10414561');
        $personal->setNomPersonal('TORRES , GINA DEL C');
        $personal->setNumPersonal('10025434');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1857'));
        $this->addReference('Personal-10025434', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('9223092');
        $personal->setNomPersonal('MARQUEZ C , WILMER J');
        $personal->setNumPersonal('10021347');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1858'));
        $this->addReference('Personal-10021347', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('14463668');
        $personal->setNomPersonal('CHAVEZ C , ANDY Y');
        $personal->setNumPersonal('10017514');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1859'));
        $this->addReference('Personal-10017514', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('7759520');
        $personal->setNomPersonal('BENITEZ M , CATY Y');
        $personal->setNumPersonal('10004564');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1860'));
        $this->addReference('Personal-10004564', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('13079573');
        $personal->setNomPersonal('CABRERA CH , DIANA Y');
        $personal->setNumPersonal('10015366');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1861'));
        $this->addReference('Personal-10015366', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('8500213');
        $personal->setNomPersonal('ROBLES M , RAFAEL A');
        $personal->setNumPersonal('10003445');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1862'));
        $this->addReference('Personal-10003445', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('11114684');
        $personal->setNomPersonal('GUERRERO M , ROGER A');
        $personal->setNumPersonal('10017538');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1863'));
        $this->addReference('Personal-10017538', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('12341525');
        $personal->setNomPersonal('ROLDAN B , MIRIAM C');
        $personal->setNumPersonal('10017886');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1864'));
        $this->addReference('Personal-10017886', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('10470505');
        $personal->setNomPersonal('PEREIRA PUENTE , JOSEFINA DEL');
        $personal->setNumPersonal('10015709');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1865'));
        $this->addReference('Personal-10015709', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('8104666');
        $personal->setNomPersonal('HERNANDEZ S , ALEIDA C');
        $personal->setNumPersonal('10017325');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1866'));
        $this->addReference('Personal-10017325', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('15234780');
        $personal->setNomPersonal('SOTO C , PEDRO A');
        $personal->setNumPersonal('10021629');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1867'));
        $this->addReference('Personal-10021629', $personal);
            $manager->persist($personal);

        // gerencia 72

        $personal = new Personal();
        $personal->setCedula('12102141');
        $personal->setNomPersonal('GARCIA S , ANA M');
        $personal->setNumPersonal('10019186');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1868'));
        $this->addReference('Personal-10019186', $personal);
            $manager->persist($personal);


        $personal = new Personal();
        $personal->setCedula('11553485');
        $personal->setNomPersonal('KREDLI G , AHMED J');
        $personal->setNumPersonal('10017754');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1868'));
        $this->addReference('Personal-10017754', $personal);
            $manager->persist($personal);


        $personal = new Personal();
        $personal->setCedula('12122643');
        $personal->setNomPersonal('ACOSTA A , LIGIADRIANA');
        $personal->setNumPersonal('10019745');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1869'));
        $this->addReference('Personal-10019745', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('7052316');
        $personal->setNomPersonal('OCA , YESENIA D');
        $personal->setNumPersonal('10023854');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1870'));
        $this->addReference('Personal-10023854', $personal);
            $manager->persist($personal);


        $personal = new Personal();
        $personal->setCedula('16381716');
        $personal->setNomPersonal('BENITEZ S , SUBMERY Y');
        $personal->setNumPersonal('10017160');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1870'));
        $this->addReference('Personal-10017160', $personal);
            $manager->persist($personal);


        $personal = new Personal();
        $personal->setCedula('13349185');
        $personal->setNomPersonal('RODRIGUEZ L , FANNY E');
        $personal->setNumPersonal('10023740');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1871'));
        $this->addReference('Personal-10023740', $personal);
            $manager->persist($personal);


        $personal = new Personal();
        $personal->setCedula('15365606');
        $personal->setNomPersonal('CASTILLO R , MASSIEL I');
        $personal->setNumPersonal('10021499');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1872'));
        $this->addReference('Personal-10021499', $personal);
            $manager->persist($personal);


        $personal = new Personal();
        $personal->setCedula('15862812');
        $personal->setNomPersonal('ESCALANTE M , JEAN N');
        $personal->setNumPersonal('10023728');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1872'));
        $this->addReference('Personal-10023728', $personal);
            $manager->persist($personal);


        $personal = new Personal();
        $personal->setCedula('6325997');
        $personal->setNomPersonal('RODRIGUEZ H , MARLENE G');
        $personal->setNumPersonal('10017660');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1872'));
        $this->addReference('Personal-10017660', $personal);
            $manager->persist($personal);


        $personal = new Personal();
        $personal->setCedula('16229749');
        $personal->setNomPersonal('RAMIREZ P , LEONOR C');
        $personal->setNumPersonal('10020674');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1873'));
        $this->addReference('Personal-10020674', $personal);
            $manager->persist($personal);


        $personal = new Personal();
        $personal->setCedula('12495326');
        $personal->setNomPersonal('DAVALILLO T , MAURA V');
        $personal->setNumPersonal('10021579');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1874'));
        $this->addReference('Personal-10021579', $personal);
            $manager->persist($personal);


        $personal = new Personal();
        $personal->setCedula('15644427');
        $personal->setNomPersonal('OLIVO P , HECTOR A');
        $personal->setNumPersonal('10019345');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1875'));
        $this->addReference('Personal-10019345', $personal);
            $manager->persist($personal);


        $personal = new Personal();
        $personal->setCedula('16596973');
        $personal->setNomPersonal('AGUIAR Q , NELSI M');
        $personal->setNumPersonal('10021187');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1876'));
        $this->addReference('Personal-10021187', $personal);
            $manager->persist($personal);


        $personal = new Personal();
        $personal->setCedula('14462273');
        $personal->setNomPersonal('GUERRA G , MARIA');
        $personal->setNumPersonal('10020693');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1876'));
        $this->addReference('Personal-10020693', $personal);
            $manager->persist($personal);


        $personal = new Personal();
        $personal->setCedula('11783799');
        $personal->setNomPersonal('CORDERO M , DORBETY DEL V');
        $personal->setNumPersonal('10022126');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1877'));
        $this->addReference('Personal-10022126', $personal);
            $manager->persist($personal);


        $personal = new Personal();
        $personal->setCedula('10327917');
        $personal->setNomPersonal('SANCHEZ  V , YDIA J');
        $personal->setNumPersonal('10021182');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1877'));
        $this->addReference('Personal-10021182', $personal);
            $manager->persist($personal);


        $personal = new Personal();
        $personal->setCedula('4028190');
        $personal->setNomPersonal('RODRIGUEZ A , LEIDA DEL C');
        $personal->setNumPersonal('10015688');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1878'));
        $this->addReference('Personal-10015688', $personal);
            $manager->persist($personal);


        $personal = new Personal();
        $personal->setCedula('8596360');
        $personal->setNomPersonal('GONZALEZ C , CELGIA T');
        $personal->setNumPersonal('10021065');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1879'));
        $this->addReference('Personal-10021065', $personal);
            $manager->persist($personal);


        $personal = new Personal();
        $personal->setCedula('15018158');
        $personal->setNomPersonal('ORCIAL , KATIUSCA C');
        $personal->setNumPersonal('10020669');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1880'));
        $this->addReference('Personal-10020669', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('14294425');
        $personal->setNomPersonal('PORTILLA M. , ERICK A.');
        $personal->setNumPersonal('10020794');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1880'));
        $this->addReference('Personal-10020794', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('17991332');
        $personal->setNomPersonal('OSTOS T , SINTHYA J');
        $personal->setNumPersonal('10020717');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1880'));
        $this->addReference('Personal-10020717', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('11001355');
        $personal->setNomPersonal('TORRES , GIPSIE C');
        $personal->setNumPersonal('10019030');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1880'));
        $this->addReference('Personal-10019030', $personal);
            $manager->persist($personal);



        $personal = new Personal();
        $personal->setCedula('14079960');
        $personal->setNomPersonal('MORENO R , RICHARD A');
        $personal->setNumPersonal('10021188');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1881'));
        $this->addReference('Personal-10021188', $personal);
            $manager->persist($personal);


        $personal = new Personal();
        $personal->setCedula('13693424');
        $personal->setNomPersonal('MUÑOZ M , KIZZY C');
        $personal->setNumPersonal('10016018');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1882'));
        $this->addReference('Personal-10016018', $personal);
            $manager->persist($personal);


        $personal = new Personal();
        $personal->setCedula('8781743');
        $personal->setNomPersonal('QUIÑONES G , MARJORIE J');
        $personal->setNumPersonal('10021435');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1882'));
        $this->addReference('Personal-10021435', $personal);
            $manager->persist($personal);


        $personal = new Personal();
        $personal->setCedula('18764580');
        $personal->setNomPersonal('CARDOZA P , EDNY P');
        $personal->setNumPersonal('10017818');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1882'));
        $this->addReference('Personal-10017818', $personal);
            $manager->persist($personal);


        $personal = new Personal();
        $personal->setCedula('7565339');
        $personal->setNomPersonal('MARTINEZ C , ARIANY');
        $personal->setNumPersonal('10024093');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1883'));
        $this->addReference('Personal-10024093', $personal);
            $manager->persist($personal);


        $personal = new Personal();
        $personal->setCedula('6930161');
        $personal->setNomPersonal('PEROZA P , JANETH E');
        $personal->setNumPersonal('10024092');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1884'));
        $this->addReference('Personal-10024092', $personal);
            $manager->persist($personal);


        $personal = new Personal();
        $personal->setCedula('12445786');
        $personal->setNomPersonal('BENITEZ Z , DESIREE J');
        $personal->setNumPersonal('10017647');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1885'));
        $this->addReference('Personal-10017647', $personal);
            $manager->persist($personal);


        $personal = new Personal();
        $personal->setCedula('13810743');
        $personal->setNomPersonal('BARRIOS C , NAILETH L');
        $personal->setNumPersonal('10022500');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1886'));
        $this->addReference('Personal-10022500', $personal);
            $manager->persist($personal);


        $personal = new Personal();
        $personal->setCedula('7539066');
        $personal->setNomPersonal('PEREZ L , DARWIN Y');
        $personal->setNumPersonal('10017864');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1887'));
        $this->addReference('Personal-10017864', $personal);
            $manager->persist($personal);


        $personal = new Personal();
        $personal->setCedula('12238888');
        $personal->setNomPersonal('MEDINA M , JUAN D');
        $personal->setNumPersonal('10020784');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1888'));
        $this->addReference('Personal-10020784', $personal);
            $manager->persist($personal);


        $personal = new Personal();
        $personal->setCedula('7566944');
        $personal->setNomPersonal('URQUIA H , FRANK J');
        $personal->setNumPersonal('10002917');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1889'));
        $this->addReference('Personal-10002917', $personal);
            $manager->persist($personal);


        $personal = new Personal();
        $personal->setCedula('11345698');
        $personal->setNomPersonal('SANCHEZ J , ROGER A');
        $personal->setNumPersonal('10019698');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1890'));
        $this->addReference('Personal-10019698', $personal);
            $manager->persist($personal);


        $personal = new Personal();
        $personal->setCedula('14923347');
        $personal->setNomPersonal('CARRIZALEZ H , MARILUZ');
        $personal->setNumPersonal('10021796');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1891'));
        $this->addReference('Personal-10021796', $personal);
            $manager->persist($personal);


        $personal = new Personal();
        $personal->setCedula('6299791');
        $personal->setNomPersonal('ENCINOZO C , SONIA M');
        $personal->setNumPersonal('10019891');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1892'));
        $this->addReference('Personal-10019891', $personal);
            $manager->persist($personal);


        $personal = new Personal();
        $personal->setCedula('10233389');
        $personal->setNomPersonal('MERCHAN G , RINA X');
        $personal->setNumPersonal('10022222');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1893'));
        $this->addReference('Personal-10022222', $personal);
            $manager->persist($personal);


        $personal = new Personal();
        $personal->setCedula('14302576');
        $personal->setNomPersonal('SANCHEZ S , CARMEN J');
        $personal->setNumPersonal('10021485');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1893'));
        $this->addReference('Personal-10021485', $personal);
            $manager->persist($personal);


        $personal = new Personal();
        $personal->setCedula('15744539');
        $personal->setNomPersonal('BARICELLI A , RICARDO A');
        $personal->setNumPersonal('10020613');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1894'));
        $this->addReference('Personal-10020613', $personal);
            $manager->persist($personal);


        $personal = new Personal();
        $personal->setCedula('11095289');
        $personal->setNomPersonal('DIAZ R , ORQUIDEA DEL V');
        $personal->setNumPersonal('10016083');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1894'));
        $this->addReference('Personal-10016083', $personal);
            $manager->persist($personal);


        $personal = new Personal();
        $personal->setCedula('14024162');
        $personal->setNomPersonal('DURAN R , MARSOVIA DEL C');
        $personal->setNumPersonal('10021991');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1895'));
        $this->addReference('Personal-10021991', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('13899649');
        $personal->setNomPersonal('VILLANUEVA M , WILLIAMS J');
        $personal->setNumPersonal('10020785');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1895'));
        $this->addReference('Personal-10020785', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('13539961');
        $personal->setNomPersonal('MARQUEZ R , MARIA E');
        $personal->setNumPersonal('10016774');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1895'));
        $this->addReference('Personal-10016774', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('13193786');
        $personal->setNomPersonal('LEON F , DESIREE DEL C');
        $personal->setNumPersonal('10021987');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1895'));
        $this->addReference('Personal-10021987', $personal);
            $manager->persist($personal);



        $personal = new Personal();
        $personal->setCedula('17031907');
        $personal->setNomPersonal('PEROZO G , CARLOS A');
        $personal->setNumPersonal('10021908');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1896'));
        $this->addReference('Personal-10021908', $personal);
            $manager->persist($personal);


        $personal = new Personal();
        $personal->setCedula('15247279');
        $personal->setNomPersonal('RENGIFO M , VICTOR R');
        $personal->setNumPersonal('10020710');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1897'));
        $this->addReference('Personal-10020710', $personal);
            $manager->persist($personal);


        $personal = new Personal();
        $personal->setCedula('15397449');
        $personal->setNomPersonal('RODRIGUEZ R , DIANA J');
        $personal->setNumPersonal('10017620');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1897'));
        $this->addReference('Personal-10017620', $personal);
            $manager->persist($personal);


        $personal = new Personal();
        $personal->setCedula('14923412');
        $personal->setNomPersonal('GUTIERREZ R , RODNY J');
        $personal->setNumPersonal('10022037');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1897'));
        $this->addReference('Personal-10022037', $personal);
            $manager->persist($personal);


        $personal = new Personal();
        $personal->setCedula('12393013');
        $personal->setNomPersonal('RUIZ  C , RUBEN  J');
        $personal->setNumPersonal('10019647');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1897'));
        $this->addReference('Personal-10019647', $personal);
            $manager->persist($personal);


        $personal = new Personal();
        $personal->setCedula('14514955');
        $personal->setNomPersonal('HISTOL R , MARIA Y');
        $personal->setNumPersonal('10017502');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1898'));
        $this->addReference('Personal-10017502', $personal);
            $manager->persist($personal);


        $personal = new Personal();
        $personal->setCedula('17777555');
        $personal->setNomPersonal('RODRIGUEZ  T , ELYMAR E');
        $personal->setNumPersonal('10019387');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1898'));
        $this->addReference('Personal-10019387', $personal);
            $manager->persist($personal);


        $personal = new Personal();
        $personal->setCedula('10862708');
        $personal->setNomPersonal('GARCIA P , AILEEN A');
        $personal->setNumPersonal('10019028');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1898'));
        $this->addReference('Personal-10019028', $personal);
            $manager->persist($personal);


        $personal = new Personal();
        $personal->setCedula('14209381');
        $personal->setNomPersonal('SALCEDO M , RODNEY M');
        $personal->setNumPersonal('10021965');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1899'));
        $this->addReference('Personal-10021965', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('11166093');
        $personal->setNomPersonal('GAMBOA M , JEZARETH');
        $personal->setNumPersonal('10023253');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1899'));
        $this->addReference('Personal-10023253', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('13058951');
        $personal->setNomPersonal('FAJARDO B , NORKYS');
        $personal->setNumPersonal('10019305');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1900'));
        $this->addReference('Personal-10019305', $personal);
            $manager->persist($personal);


        $personal = new Personal();
        $personal->setCedula('12207905');
        $personal->setNomPersonal('COLMENAREZ R , IRIS M');
        $personal->setNumPersonal('10016863');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1901'));
        $this->addReference('Personal-10016863', $personal);
            $manager->persist($personal);


        $personal = new Personal();
        $personal->setCedula('13955447');
        $personal->setNomPersonal('MUSKUS C , KATTYUSKA E');
        $personal->setNumPersonal('10016081');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1902'));
        $this->addReference('Personal-10016081', $personal);
            $manager->persist($personal);


        $personal = new Personal();
        $personal->setCedula('7920182');
        $personal->setNomPersonal('GARCIA M , PEDRO E');
        $personal->setNumPersonal('10003313');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1903'));
        $this->addReference('Personal-10003313', $personal);
            $manager->persist($personal);


        $personal = new Personal();
        $personal->setCedula('14025250');
        $personal->setNomPersonal('RIVAS P , DHAMELYS C');
        $personal->setNumPersonal('10016121');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1904'));
        $this->addReference('Personal-10016121', $personal);
            $manager->persist($personal);


        $personal = new Personal();
        $personal->setCedula('10399941');
        $personal->setNomPersonal('RONDON B , JULIO C');
        $personal->setNumPersonal('10017250');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1905'));
        $this->addReference('Personal-10017250', $personal);
            $manager->persist($personal);


        $personal = new Personal();
        $personal->setCedula('12606575');
        $personal->setNomPersonal('TOVAR L , EVELYN F');
        $personal->setNumPersonal('10016085');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1906'));
        $this->addReference('Personal-10016085', $personal);
            $manager->persist($personal);


        $personal = new Personal();
        $personal->setCedula('19219177');
        $personal->setNomPersonal('GONZALEZ F , MARIANGEL B');
        $personal->setNumPersonal('10024411');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1907'));
        $this->addReference('Personal-10024411', $personal);
            $manager->persist($personal);


        $personal = new Personal();
        $personal->setCedula('4589185');
        $personal->setNomPersonal('LATTUF , ROSA M');
        $personal->setNumPersonal('10017224');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1908'));
        $this->addReference('Personal-10017224', $personal);
            $manager->persist($personal);


        $personal = new Personal();
        $personal->setCedula('14862668');
        $personal->setNomPersonal('MORILLO V. , ALFREDO J.');
        $personal->setNumPersonal('10015839');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1909'));
        $this->addReference('Personal-10015839', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('12206361');
        $personal->setNomPersonal('GARCIA M , YELISA M');
        $personal->setNumPersonal('10018544');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1910'));
        $this->addReference('Personal-10018544', $personal);
            $manager->persist($personal);


        $personal = new Personal();
        $personal->setCedula('13146847');
        $personal->setNomPersonal('CORDERO DE T , THAIS M');
        $personal->setNumPersonal('10020666');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1911'));
        $this->addReference('Personal-10020666', $personal);
            $manager->persist($personal);


        $personal = new Personal();
        $personal->setCedula('4173295');
        $personal->setNomPersonal('CHIRINOS M , ALIDA E');
        $personal->setNumPersonal('10019512');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1912'));
        $this->addReference('Personal-10019512', $personal);
            $manager->persist($personal);

        // gerencia 73

        $personal = new Personal();
        $personal->setCedula('18085840');
        $personal->setNomPersonal('SEIJO N , ANDREA V');
        $personal->setNumPersonal('10024315');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1913'));
        $this->addReference('Personal-10024315', $personal);
            $manager->persist($personal);


        $personal = new Personal();
        $personal->setCedula('13354720');
        $personal->setNomPersonal('LOPEZ Z , DENISSE M');
        $personal->setNumPersonal('10021540');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1914'));
        $this->addReference('Personal-10021540', $personal);
            $manager->persist($personal);


        $personal = new Personal();
        $personal->setCedula('12319321');
        $personal->setNomPersonal('HERNANDEZ R , CARLOS E');
        $personal->setNumPersonal('10019616');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1914'));
        $this->addReference('Personal-10019616', $personal);
            $manager->persist($personal);


        $personal = new Personal();
        $personal->setCedula('15529946');
        $personal->setNomPersonal('GOMEZ S , ELIECER M');
        $personal->setNumPersonal('10021539');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1915'));
        $this->addReference('Personal-10021539', $personal);
            $manager->persist($personal);


        $personal = new Personal();
        $personal->setCedula('17517841');
        $personal->setNomPersonal('PEREZ G , DEILIMAR DEL V');
        $personal->setNumPersonal('10022544');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1915'));
        $this->addReference('Personal-10022544', $personal);
            $manager->persist($personal);


        $personal = new Personal();
        $personal->setCedula('16654103');
        $personal->setNomPersonal('VELA S , MANUEL M');
        $personal->setNumPersonal('10025314');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1915'));
        $this->addReference('Personal-10025314', $personal);
            $manager->persist($personal);


        $personal = new Personal();
        $personal->setCedula('17518909');
        $personal->setNomPersonal('PADILLA I , ROSANA DEL C');
        $personal->setNumPersonal('10024920');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1915'));
        $this->addReference('Personal-10024920', $personal);
            $manager->persist($personal);


        $personal = new Personal();
        $personal->setCedula('17199725');
        $personal->setNomPersonal('MORENO C , SOFIA A');
        $personal->setNumPersonal('10021918');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1915'));
        $this->addReference('Personal-10021918', $personal);
            $manager->persist($personal);


        $personal = new Personal();
        $personal->setCedula('15190907');
        $personal->setNomPersonal('CASTILLO L , NELSY DEL C');
        $personal->setNumPersonal('10019851');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1915'));
        $this->addReference('Personal-10019851', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('15081479');
        $personal->setNomPersonal('RUIZ , ADRIAN J');
        $personal->setNumPersonal('10023286');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1916'));
        $this->addReference('Personal-10023286', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('14802254');
        $personal->setNomPersonal('MORA R , JESUS A');
        $personal->setNumPersonal('10021743');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1917'));
        $this->addReference('Personal-10021743', $personal);
            $manager->persist($personal);

        // gerencia 74

        $personal = new Personal();
        $personal->setCedula('9824104');
        $personal->setNomPersonal('VELASQUEZ G , ZORAIDA DEL C');
        $personal->setNumPersonal('10020629');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1918'));
        $this->addReference('Personal-10020629', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('10020629');
        $personal->setNomPersonal('MOROCOIMA B , SIMON A');
        $personal->setNumPersonal('10001360');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1919'));
        $this->addReference('Personal-10001360', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('14657775');
        $personal->setNomPersonal('GONZALEZ P , REBECA CH');
        $personal->setNumPersonal('10017915');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1920'));
        $this->addReference('Personal-10017915', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('11160581');
        $personal->setNomPersonal('LOPEZ S , SOCRATES D');
        $personal->setNumPersonal('10017245');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1920'));
        $this->addReference('Personal-10017245', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('13770259');
        $personal->setNomPersonal('PINILLA G , NEYDA K');
        $personal->setNumPersonal('10019857');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1920'));
        $this->addReference('Personal-10019857', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('15059919');
        $personal->setNomPersonal('PRIETO P , RICARDO J');
        $personal->setNumPersonal('10019471');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1921'));
        $this->addReference('Personal-10019471', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('7661479');
        $personal->setNomPersonal('MARTINEZ M , RAFAEL A');
        $personal->setNumPersonal('10003004');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1922'));
        $this->addReference('Personal-10003004', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('16135661');
        $personal->setNomPersonal('RODRIGUEZ  H. , ODAN  J.');
        $personal->setNumPersonal('10020464');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1923'));
        $this->addReference('Personal-10020464', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('17894367');
        $personal->setNomPersonal('ROSAS L , MARIA V');
        $personal->setNumPersonal('10020973');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1924'));
        $this->addReference('Personal-10020973', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('16183051');
        $personal->setNomPersonal('FLORES P , MARIA V');
        $personal->setNumPersonal('10022125');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1925'));
        $this->addReference('Personal-10022125', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('11198150');
        $personal->setNomPersonal('BETANCOURT S , ADRIA A');
        $personal->setNumPersonal('10016875');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1926'));
        $this->addReference('Personal-10016875', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('5452566');
        $personal->setNomPersonal('GALINDEZ A , IRENE J');
        $personal->setNumPersonal('10017860');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1927'));
        $this->addReference('Personal-10017860', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('11860701');
        $personal->setNomPersonal('PRIETO L , OSCAR A.');
        $personal->setNumPersonal('10017857');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1928'));
        $this->addReference('Personal-10017857', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('5910754');
        $personal->setNomPersonal('SALAVERRIA M , JESUS H');
        $personal->setNumPersonal('10002419');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1929'));
        $this->addReference('Personal-10002419', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('10500739');
        $personal->setNomPersonal('SANTIAGO , JESUS A');
        $personal->setNumPersonal('10003966');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1929'));
        $this->addReference('Personal-10003966', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('13069323');
        $personal->setNomPersonal('CABRERA R , REGINA R');
        $personal->setNumPersonal('10016815');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1929'));
        $this->addReference('Personal-10016815', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('19366103');
        $personal->setNomPersonal('MARTINEZ A , INGRID A');
        $personal->setNumPersonal('10021803');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1930'));
        $this->addReference('Personal-10021803', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('10456965');
        $personal->setNomPersonal('CABELLO D , CRISALIDA DEL V');
        $personal->setNumPersonal('10017025');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1930'));
        $this->addReference('Personal-10017025', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('9955177');
        $personal->setNomPersonal('DELGADO U , JOSE G');
        $personal->setNumPersonal('10003822');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1931'));
        $this->addReference('Personal-10003822', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('12311614');
        $personal->setNomPersonal('MARTINEZ P , OSCAR J');
        $personal->setNumPersonal('10017862');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1932'));
        $this->addReference('Personal-10017862', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('8837725');
        $personal->setNomPersonal('LINARES A , ALONSO E');
        $personal->setNumPersonal('10023484');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1933'));
        $this->addReference('Personal-10023484', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('13193036');
        $personal->setNomPersonal('MARTINEZ   S , JHONNY A');
        $personal->setNumPersonal('10023608');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1933'));
        $this->addReference('Personal-10023608', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('16273819');
        $personal->setNomPersonal('GUERRERO C , JHON J');
        $personal->setNumPersonal('10023220');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1933'));
        $this->addReference('Personal-10023220', $personal);
            $manager->persist($personal);


        $personal = new Personal();
        $personal->setCedula('4973943');
        $personal->setNomPersonal('RODRIGUEZ T , NEMESIO D');
        $personal->setNumPersonal('10018022');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1934'));
        $this->addReference('Personal-10018022', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('16005529');
        $personal->setNomPersonal('FIGUERA G , JUAN E');
        $personal->setNumPersonal('10017728');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1934'));
        $this->addReference('Personal-10017728', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('5888327');
        $personal->setNomPersonal('JAIMES U , JOSE R');
        $personal->setNumPersonal('10019974');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1934'));
        $this->addReference('Personal-10019974', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('6749945');
        $personal->setNomPersonal('PINEDA M , LUIS A');
        $personal->setNumPersonal('10004871');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1934'));
        $this->addReference('Personal-10004871', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('15494304');
        $personal->setNomPersonal('GONZALEZ R , GUSTAVO A');
        $personal->setNumPersonal('10018425');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1934'));
        $this->addReference('Personal-10018425', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('12106826');
        $personal->setNomPersonal('TERAN M , OMAR X');
        $personal->setNumPersonal('10024300');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1934'));
        $this->addReference('Personal-10024300', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('6096083');
        $personal->setNomPersonal('MONTES C , ALCIDES A');
        $personal->setNumPersonal('10015854');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1934'));
        $this->addReference('Personal-10015854', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('4974043');
        $personal->setNomPersonal('JAIMES U , LUIS E');
        $personal->setNumPersonal('10001835');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1934'));
        $this->addReference('Personal-10001835', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('3477512');
        $personal->setNomPersonal('ADRIAN R , PEDRO A');
        $personal->setNumPersonal('10016616');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1934'));
        $this->addReference('Personal-10016616', $personal);
            $manager->persist($personal);


        $personal = new Personal();
        $personal->setCedula('8048842');
        $personal->setNomPersonal('ALARCON D , ANA Y');
        $personal->setNumPersonal('10019950');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1935'));
        $this->addReference('Personal-10019950', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('14149115');
        $personal->setNomPersonal('MORENO  S. , IRMA  C.');
        $personal->setNumPersonal('10020465');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1935'));
        $this->addReference('Personal-10020465', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('15007994');
        $personal->setNomPersonal('DIAZ  A , HECTOR A');
        $personal->setNumPersonal('10021387');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1935'));
        $this->addReference('Personal-10021387', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('17249348');
        $personal->setNomPersonal('MORENO M , CARLOS J');
        $personal->setNumPersonal('10020042');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1935'));
        $this->addReference('Personal-10020042', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('18728501');
        $personal->setNomPersonal('DELGADO R , LEUDY M');
        $personal->setNumPersonal('10025354');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1935'));
        $this->addReference('Personal-10025354', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('12761100');
        $personal->setNomPersonal('LIRA C , HAYZEL DEL V');
        $personal->setNumPersonal('10017726');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1936'));
        $this->addReference('Personal-10017726', $personal);
            $manager->persist($personal);


        $personal = new Personal();
        $personal->setCedula('6968239');
        $personal->setNomPersonal('ASSISO G , ORLANDO J');
        $personal->setNumPersonal('10012777');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1937'));
        $this->addReference('Personal-10012777', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('13117079');
        $personal->setNomPersonal('MEJIA  H. , JOSE A.');
        $personal->setNumPersonal('10020477');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1938'));
        $this->addReference('Personal-10020477', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('14383232');
        $personal->setNomPersonal('MACHADO M , EDIXON C');
        $personal->setNumPersonal('10023482');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1939'));
        $this->addReference('Personal-10023482', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('28300102');
        $personal->setNomPersonal('ANGULO M , MARLON J');
        $personal->setNumPersonal('10024297');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1939'));
        $this->addReference('Personal-10024297', $personal);
            $manager->persist($personal);


        $personal = new Personal();
        $personal->setCedula('4269865');
        $personal->setNomPersonal('MONTEROLA , JUAN DE LA C');
        $personal->setNumPersonal('10001329');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1940'));
        $this->addReference('Personal-10001329', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('18369086');
        $personal->setNomPersonal('LOZADA R , EDUARDO E');
        $personal->setNumPersonal('10023219');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1940'));
        $this->addReference('Personal-10023219', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('12575047');
        $personal->setNomPersonal('VARELA J , JAVIER A');
        $personal->setNumPersonal('10016872');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1940'));
        $this->addReference('Personal-10016872', $personal);
            $manager->persist($personal);


        $personal = new Personal();
        $personal->setCedula('4043175');
        $personal->setNomPersonal('CALZADILLA , ALEXIS J');
        $personal->setNumPersonal('10019975');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1941'));
        $this->addReference('Personal-10019975', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('15333033');
        $personal->setNomPersonal('PINTO H , CESAR E');
        $personal->setNumPersonal('10024295');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1941'));
        $this->addReference('Personal-10024295', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('7092958');
        $personal->setNomPersonal('NUÑEZ R , RAFAEL H.');
        $personal->setNumPersonal('10024160');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1942'));
        $this->addReference('Personal-10024160', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('16802648');
        $personal->setNomPersonal('ZARATE  S , RAUL  A');
        $personal->setNumPersonal('10019007');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1942'));
        $this->addReference('Personal-10019007', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('8593387');
        $personal->setNomPersonal('MONTERO C , WILLIANS C');
        $personal->setNumPersonal('10022337');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1943'));
        $this->addReference('Personal-10022337', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('7482378');
        $personal->setNomPersonal('SOTO , SATURNO R');
        $personal->setNumPersonal('10022338');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1943'));
        $this->addReference('Personal-10022338', $personal);
            $manager->persist($personal);


        $personal = new Personal();
        $personal->setCedula('9477961');
        $personal->setNomPersonal('HERNANDEZ   R. , DOMINGO   A.');
        $personal->setNumPersonal('10023252');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1944'));
        $this->addReference('Personal-10023252', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('15600149');
        $personal->setNomPersonal('BARRETO R , AYARITH Y');
        $personal->setNumPersonal('10021503');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1945'));
        $this->addReference('Personal-10021503', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('11273031');
        $personal->setNomPersonal('BARRIOS D , MERLINA J');
        $personal->setNumPersonal('10018426');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1946'));
        $this->addReference('Personal-10018426', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('5592882');
        $personal->setNomPersonal('CARVAJAL S , CARLOS A');
        $personal->setNumPersonal('10002227');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1947'));
        $this->addReference('Personal-10002227', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('6656893');
        $personal->setNomPersonal('ANDRADE S , JOSE I');
        $personal->setNumPersonal('10002580');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1948'));
        $this->addReference('Personal-10002580', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('11407049');
        $personal->setNomPersonal('CRUZ S , SUSAN M');
        $personal->setNumPersonal('10004093');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1949'));
        $this->addReference('Personal-10004093', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('7572307');
        $personal->setNomPersonal('PARTIDAS R , JESUS R');
        $personal->setNumPersonal('10002921');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1950'));
        $this->addReference('Personal-10002921', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('8593389');
        $personal->setNomPersonal('GUEVARA F , ANGEL J');
        $personal->setNumPersonal('10016649');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1951'));
        $this->addReference('Personal-10016649', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('12742168');
        $personal->setNomPersonal('MIQUILENA R. , ROSA Y');
        $personal->setNumPersonal('10019718');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1952'));
        $this->addReference('Personal-10019718', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('12721267');
        $personal->setNomPersonal('MANGLE C , LINO J');
        $personal->setNumPersonal('10023413');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1953'));
        $this->addReference('Personal-10023413', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('14484171');
        $personal->setNomPersonal('CANOS D , NURY');
        $personal->setNumPersonal('10015871');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1954'));
        $this->addReference('Personal-10015871', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('7182414');
        $personal->setNomPersonal('SANTOS V , JOSE M');
        $personal->setNumPersonal('10022335');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1955'));
        $this->addReference('Personal-10022335', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('15955007');
        $personal->setNomPersonal('RUIZ G , YUSMELY B');
        $personal->setNumPersonal('10024652');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1956'));
        $this->addReference('Personal-10024652', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('18362758');
        $personal->setNomPersonal('TORRES P , JULIAN A');
        $personal->setNumPersonal('10021380');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1957'));
        $this->addReference('Personal-10021380', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('16947950');
        $personal->setNomPersonal('REZA P , HOLDAN A');
        $personal->setNumPersonal('10019919');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1957'));
        $this->addReference('Personal-10019919', $personal);
            $manager->persist($personal);

        // gerencia 75

        $personal = new Personal();
        $personal->setCedula('6225607');
        $personal->setNomPersonal('LUCENA R , ANTONIO J');
        $personal->setNumPersonal('10019720');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1958'));
        $this->addReference('Personal-10019720', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('13803401');
        $personal->setNomPersonal('CHINCHILLA M , MARIA G');
        $personal->setNumPersonal('10015954');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1959'));
        $this->addReference('Personal-10015954', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('11198894');
        $personal->setNomPersonal('BISTOCHETT , CESAR S');
        $personal->setNumPersonal('10019817');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1960'));
        $this->addReference('Personal-10019817', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('13987902');
        $personal->setNomPersonal('NASREDDINE EL F , WISSAN');
        $personal->setNumPersonal('10023579');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1961'));
        $this->addReference('Personal-10023579', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('15495935');
        $personal->setNomPersonal('FONSECA A , NAYANNA R');
        $personal->setNumPersonal('10020679');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1961'));
        $this->addReference('Personal-10020679', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('16305168');
        $personal->setNomPersonal('SANCHEZ V , YAMILE D');
        $personal->setNumPersonal('10019741');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1961'));
        $this->addReference('Personal-10019741', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('17256340');
        $personal->setNomPersonal('VILLEGAS C , DIANA Y');
        $personal->setNumPersonal('10021842');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1961'));
        $this->addReference('Personal-10021842', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('12118296');
        $personal->setNomPersonal('RODRIGUEZ  S. , GERTRUDYS  M.');
        $personal->setNumPersonal('10020792');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1961'));
        $this->addReference('Personal-10020792', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('8455780');
        $personal->setNomPersonal('GUTIERREZ G , TRINIDAD DEL V');
        $personal->setNumPersonal('10017907');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1961'));
        $this->addReference('Personal-10017907', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('14880310');
        $personal->setNomPersonal('PERESSON L , MARIO A');
        $personal->setNumPersonal('10021391');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1961'));
        $this->addReference('Personal-10021391', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('15102655');
        $personal->setNomPersonal('RAMOS B , OMAR A');
        $personal->setNumPersonal('10021381');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1961'));
        $this->addReference('Personal-10021381', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('9881424');
        $personal->setNomPersonal('ZAGO K , MARIO F');
        $personal->setNumPersonal('10020050');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1961'));
        $this->addReference('Personal-10020050', $personal);
            $manager->persist($personal);


        $personal = new Personal();
        $personal->setCedula('7122762');
        $personal->setNomPersonal('RODRIGUEZ A , AISKEL F');
        $personal->setNumPersonal('10021685');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1962'));
        $this->addReference('Personal-10021685', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('9881673');
        $personal->setNomPersonal('HERNANDEZ F , ALDRIN A');
        $personal->setNumPersonal('10017405');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1963'));
        $this->addReference('Personal-10017405', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('10323398');
        $personal->setNomPersonal('TOLEDO H , MAYRA E');
        $personal->setNumPersonal('10019730');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1964'));
        $this->addReference('Personal-10019730', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('14121530');
        $personal->setNomPersonal('CONTRERAS B , BERNARDO J');
        $personal->setNumPersonal('10017409');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1965'));
        $this->addReference('Personal-10017409', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('13648457');
        $personal->setNomPersonal('CARRASCO CH , MARJORIE M');
        $personal->setNumPersonal('10015691');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1966'));
        $this->addReference('Personal-10015691', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('13764069');
        $personal->setNomPersonal('VILLEGAS D , DARLING J');
        $personal->setNumPersonal('10015370');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1967'));
        $this->addReference('Personal-10015370', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('15385109');
        $personal->setNomPersonal('NAVARRO G , ANDRES A');
        $personal->setNumPersonal('10021840');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1968'));
        $this->addReference('Personal-10021840', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('16857904');
        $personal->setNomPersonal('DELGADO P , MARYURIS D');
        $personal->setNumPersonal('10015791');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1969'));
        $this->addReference('Personal-10015791', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('11069924');
        $personal->setNomPersonal('RODRIGUEZ Y. , NINOSKA DEL V.');
        $personal->setNumPersonal('10016854');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1970'));
        $this->addReference('Personal-10016854', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('6313430');
        $personal->setNomPersonal('VIVAS R , JOSE H');
        $personal->setNumPersonal('10017412');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1971'));
        $this->addReference('Personal-10017412', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('16707168');
        $personal->setNomPersonal('PADILLA I , MARIA E');
        $personal->setNumPersonal('10021841');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1972'));
        $this->addReference('Personal-10021841', $personal);
            $manager->persist($personal);

        // gerencia 76

        $personal = new Personal();
        $personal->setCedula('649319');
        $personal->setNomPersonal('DELGADO G , LUCIO A');
        $personal->setNumPersonal('10017501');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1973'));
        $this->addReference('Personal-10017501', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('8087496');
        $personal->setNomPersonal('QUINTERO M , RUBIO');
        $personal->setNumPersonal('10015809');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1974'));
        $this->addReference('Personal-10015809', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('4174590');
        $personal->setNomPersonal('RIVERO C , NEIDA L');
        $personal->setNumPersonal('10021468');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1974'));
        $this->addReference('Personal-10021468', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('14754189');
        $personal->setNomPersonal('AZUAJE G , SORILENA DEL C');
        $personal->setNumPersonal('10021189');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1974'));
        $this->addReference('Personal-10021189', $personal);
            $manager->persist($personal);


        $personal = new Personal();
        $personal->setCedula('12111319');
        $personal->setNomPersonal('MEJIA D , NESTOR J');
        $personal->setNumPersonal('10025193');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1975'));
        $this->addReference('Personal-10025193', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('15259609');
        $personal->setNomPersonal('PIÑANGO M , JESUS E');
        $personal->setNumPersonal('10020053');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1975'));
        $this->addReference('Personal-10020053', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('16399686');
        $personal->setNomPersonal('ZAMBRANO R , HECTOR J');
        $personal->setNumPersonal('10020891');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1976'));
        $this->addReference('Personal-10020891', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('16135714');
        $personal->setNomPersonal('MENDEZ R , ALEJANDRO J');
        $personal->setNumPersonal('10019621');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1976'));
        $this->addReference('Personal-10019621', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('4941416');
        $personal->setNomPersonal('LEFEBRE , DIOSMERYS DEL C');
        $personal->setNumPersonal('10019670');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1977'));
        $this->addReference('Personal-10019670', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('11099533');
        $personal->setNomPersonal('REMANTON R , GISELA M');
        $personal->setNumPersonal('10018879');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1977'));
        $this->addReference('Personal-10018879', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('12721224');
        $personal->setNomPersonal('PERNALETE G , DERWIN L');
        $personal->setNumPersonal('10021057');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1977'));
        $this->addReference('Personal-10021057', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('13354214');
        $personal->setNomPersonal('BENAVIDES C , JOHANA D');
        $personal->setNumPersonal('10017504');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1977'));
        $this->addReference('Personal-10017504', $personal);
            $manager->persist($personal);


        $personal = new Personal();
        $personal->setCedula('13851205');
        $personal->setNomPersonal('MENDOZA C , JUAN M');
        $personal->setNumPersonal('10025022');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1978'));
        $this->addReference('Personal-10025022', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('15900171');
        $personal->setNomPersonal('HERRERA B , ADRIANA I');
        $personal->setNumPersonal('10023971');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1979'));
        $this->addReference('Personal-10023971', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('15892756');
        $personal->setNomPersonal('FERNANDEZ H , VIOLETA');
        $personal->setNumPersonal('10019729');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1980'));
        $this->addReference('Personal-10019729', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('13634614');
        $personal->setNomPersonal('VASQUEZ A , KAREN N');
        $personal->setNumPersonal('10020087');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1980'));
        $this->addReference('Personal-10020087', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('16085903');
        $personal->setNomPersonal('PORRAS V , JENNY J');
        $personal->setNumPersonal('10016169');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1980'));
        $this->addReference('Personal-10016169', $personal);
            $manager->persist($personal);


        $personal = new Personal();
        $personal->setCedula('23707791');
        $personal->setNomPersonal('JARAMILLO S , BIBIANA M');
        $personal->setNumPersonal('10019930');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1981'));
        $this->addReference('Personal-10019930', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('13513223');
        $personal->setNomPersonal('MORENO M , EVYRROS T');
        $personal->setNumPersonal('10020175');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1982'));
        $this->addReference('Personal-10020175', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('13810838');
        $personal->setNomPersonal('BELLERA D , LAURA S');
        $personal->setNumPersonal('10017269');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1983'));
        $this->addReference('Personal-10017269', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('5900256');
        $personal->setNomPersonal('MEJIAS , ROGER C');
        $personal->setNumPersonal('10004815');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1984'));
        $this->addReference('Personal-10004815', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('16948922');
        $personal->setNomPersonal('PLAZA Z , JAVIER E');
        $personal->setNumPersonal('10021432');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1985'));
        $this->addReference('Personal-10021432', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('14601320');
        $personal->setNomPersonal('RONDON A , ZULAY C');
        $personal->setNumPersonal('10022215');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1986'));
        $this->addReference('Personal-10022215', $personal);
            $manager->persist($personal);

        // gerencia 77

        $personal = new Personal();
        $personal->setCedula('10827506');
        $personal->setNomPersonal('CASTILLO G , LUIS D');
        $personal->setNumPersonal('10018667');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1987'));
        $this->addReference('Personal-10018667', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('4405993');
        $personal->setNomPersonal('REQUENA H , HERNAN A');
        $personal->setNumPersonal('10020675');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1988'));
        $this->addReference('Personal-10020675', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('10250037');
        $personal->setNomPersonal('MUJICA M , RICHARD S');
        $personal->setNumPersonal('10018904');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1989'));
        $this->addReference('Personal-10018904', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('12753742');
        $personal->setNomPersonal('BERRIOS R , ANGELICA V');
        $personal->setNumPersonal('10020890');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1990'));
        $this->addReference('Personal-10020890', $personal);
            $manager->persist($personal);


        $personal = new Personal();
        $personal->setCedula('17614219');
        $personal->setNomPersonal('LUGO , ANA DE LA TRINIDAD');
        $personal->setNumPersonal('10020307');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1990'));
        $this->addReference('Personal-10020307', $personal);
            $manager->persist($personal);


        $personal = new Personal();
        $personal->setCedula('13587793');
        $personal->setNomPersonal('SAMBONI , ANA M');
        $personal->setNumPersonal('10019928');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1990'));
        $this->addReference('Personal-10019928', $personal);
            $manager->persist($personal);


        $personal = new Personal();
        $personal->setCedula('7093391');
        $personal->setNomPersonal('SACCHETTI B , CLAUDIO A');
        $personal->setNumPersonal('10019925');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1990'));
        $this->addReference('Personal-10019925', $personal);
            $manager->persist($personal);


        $personal = new Personal();
        $personal->setCedula('13293216');
        $personal->setNomPersonal('RODRIGUEZ D , NALLELYS M');
        $personal->setNumPersonal('10019916');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1990'));
        $this->addReference('Personal-10019916', $personal);
            $manager->persist($personal);


        $personal = new Personal();
        $personal->setCedula('13954400');
        $personal->setNomPersonal('TORRES A , CLAUDIA O');
        $personal->setNumPersonal('10017982');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1990'));
        $this->addReference('Personal-10017982', $personal);
            $manager->persist($personal);


        $personal = new Personal();
        $personal->setCedula('12820395');
        $personal->setNomPersonal('PADRON  H. , MARLYN DEL V.');
        $personal->setNumPersonal('10017842');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1990'));
        $this->addReference('Personal-10017842', $personal);
            $manager->persist($personal);


        $personal = new Personal();
        $personal->setCedula('7102621');
        $personal->setNomPersonal('SUAREZ , JORGE A');
        $personal->setNumPersonal('10021596');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1990'));
        $this->addReference('Personal-10021596', $personal);
            $manager->persist($personal);


        $personal = new Personal();
        $personal->setCedula('7094555');
        $personal->setNomPersonal('CASTRO M , MARIANELLA');
        $personal->setNumPersonal('10019786');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1990'));
        $this->addReference('Personal-10019786', $personal);
            $manager->persist($personal);


        $personal = new Personal();
        $personal->setCedula('6976766');
        $personal->setNomPersonal('TORRES C , AURALILA DE J');
        $personal->setNumPersonal('10019717');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1990'));
        $this->addReference('Personal-10019717', $personal);
            $manager->persist($personal);



        $personal = new Personal();
        $personal->setCedula('9240119');
        $personal->setNomPersonal('BLANCO I , ALVARO A');
        $personal->setNumPersonal('10018978');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1991'));
        $this->addReference('Personal-10018978', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('9695145');
        $personal->setNomPersonal('VILLEGAS S , MARITZA J');
        $personal->setNumPersonal('10020278');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1992'));
        $this->addReference('Personal-10020278', $personal);
            $manager->persist($personal);

        // Gerencia 78

        $personal = new Personal();
        $personal->setCedula('15642974');
        $personal->setNomPersonal('BULLE C , JOHANNA C');
        $personal->setNumPersonal('10015197');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1993'));
        $this->addReference('Personal-10015197', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('19428441');
        $personal->setNomPersonal('ARMADA , JUAN C');
        $personal->setNumPersonal('10021956');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1994'));
        $this->addReference('Personal-10021956', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('8847198');
        $personal->setNomPersonal('BELLO D , ADELA D');
        $personal->setNumPersonal('10021471');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1995'));
        $this->addReference('Personal-10021471', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('15296685');
        $personal->setNomPersonal('PEREZ L , LUIS M');
        $personal->setNumPersonal('10022311');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1995'));
        $this->addReference('Personal-10022311', $personal);
            $manager->persist($personal);


        $personal = new Personal();
        $personal->setCedula('10506253');
        $personal->setNomPersonal('PAEZ , ADIRA DE J');
        $personal->setNumPersonal('10017902');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1996'));
        $this->addReference('Personal-10017902', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('15054935');
        $personal->setNomPersonal('NIETO A , MILUBEL');
        $personal->setNumPersonal('10018003');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1996'));
        $this->addReference('Personal-10018003', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('13549645');
        $personal->setNomPersonal('PARADA A , JANDRY D');
        $personal->setNumPersonal('10020062');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1996'));
        $this->addReference('Personal-10020062', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('16242135');
        $personal->setNomPersonal('BALLESTEROS P , DIANA J');
        $personal->setNumPersonal('10021510');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1997'));
        $this->addReference('Personal-10021510', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('11472918');
        $personal->setNomPersonal('GUERRA , LISEHT DEL C');
        $personal->setNumPersonal('10024294');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1998'));
        $this->addReference('Personal-10024294', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('9189651');
        $personal->setNomPersonal('PEÑARANDA G , JORGE');
        $personal->setNumPersonal('10019283');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1999'));
        $this->addReference('Personal-10019283', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('7561952');
        $personal->setNomPersonal('ARAUJO DE M , NELLY M');
        $personal->setNumPersonal('10023582');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1999'));
        $this->addReference('Personal-10023582', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('10545544');
        $personal->setNomPersonal('VALDERRAMA R. , SILVIA J.');
        $personal->setNumPersonal('10025853');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1999'));
        $this->addReference('Personal-10025853', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('11979307');
        $personal->setNomPersonal('MARTINEZ M , MONICA A');
        $personal->setNumPersonal('10021829');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-1999'));
        $this->addReference('Personal-10021829', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('6523922');
        $personal->setNomPersonal('JIMENEZ V , LIUBA G');
        $personal->setNumPersonal('10017404');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2000'));
        $this->addReference('Personal-10017404', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('12861710');
        $personal->setNomPersonal('SALAS R. , ISABEL C.');
        $personal->setNumPersonal('10017500');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2001'));
        $this->addReference('Personal-10017500', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('11521500');
        $personal->setNomPersonal('PINTO P , OSCAR D');
        $personal->setNumPersonal('10020595');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2002'));
        $this->addReference('Personal-10020595', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('7395144');
        $personal->setNomPersonal('AMARO M , CECILIO A');
        $personal->setNumPersonal('10021802');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2003'));
        $this->addReference('Personal-10021802', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('6893962');
        $personal->setNomPersonal('RODRIGUEZ R , LILIANA M');
        $personal->setNumPersonal('10017225');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2004'));
        $this->addReference('Personal-10017225', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('5276070');
        $personal->setNomPersonal('BLANCO A , GUILLERMO');
        $personal->setNumPersonal('10018445');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2005'));
        $this->addReference('Personal-10018445', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('7179176');
        $personal->setNomPersonal('MONTENEGRO J , ERNESTO E');
        $personal->setNumPersonal('10020468');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2006'));
        $this->addReference('Personal-10020468', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('13770969');
        $personal->setNomPersonal('PARRA M , GUSTAVO E');
        $personal->setNumPersonal('10017979');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2007'));
        $this->addReference('Personal-10017979', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('4444789');
        $personal->setNomPersonal('PACHECO A , PABLO  N');
        $personal->setNumPersonal('10019263');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2008'));
        $this->addReference('Personal-10019263', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('11810060');
        $personal->setNomPersonal('BOUZA C , JIMY RODNEY');
        $personal->setNumPersonal('10018750');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2009'));
        $this->addReference('Personal-10018750', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('6909207');
        $personal->setNomPersonal('RODRIGUEZ G , OSCAR J');
        $personal->setNumPersonal('10009209');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2010'));
        $this->addReference('Personal-10009209', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('12640889');
        $personal->setNomPersonal('JIMENEZ T , HUGO E');
        $personal->setNumPersonal('10012598');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2010'));
        $this->addReference('Personal-10012598', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('6130194');
        $personal->setNomPersonal('HERNANDEZ L , BENJAMIN A');
        $personal->setNumPersonal('10012603');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2010'));
        $this->addReference('Personal-10012603', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('5409671');
        $personal->setNomPersonal('ESCALONA S , KENNYS A');
        $personal->setNumPersonal('10002121');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2010'));
        $this->addReference('Personal-10002121', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('11891426');
        $personal->setNomPersonal('VELASQUEZ Y , LEOBALDO');
        $personal->setNumPersonal(' 10017927');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2011'));
        $this->addReference('Personal-10017927', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('9665984');
        $personal->setNomPersonal('RAMOS H , ALEXIS R');
        $personal->setNumPersonal('10024087');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2011'));
        $this->addReference('Personal-10024087', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('19659663');
        $personal->setNomPersonal('GONZALEZ R , MANUEL L');
        $personal->setNumPersonal('10024533');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2011'));
        $this->addReference('Personal-10024533', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('11348469');
        $personal->setNomPersonal('GAVIDIA A , JOSE A');
        $personal->setNumPersonal('10024532');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2011'));
        $this->addReference('Personal-10024532', $personal);
            $manager->persist($personal);


        $personal = new Personal();
        $personal->setCedula('6348867');
        $personal->setNomPersonal('GARCIA C , GUSTAVO E');
        $personal->setNumPersonal('10017777');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2012'));
        $this->addReference('Personal-10017777', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('6971528');
        $personal->setNomPersonal('ROMERO S , LUIS H');
        $personal->setNumPersonal('10020189');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2012'));
        $this->addReference('Personal-10020189', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('20268460');
        $personal->setNomPersonal('PINTO H , CARLOS L');
        $personal->setNumPersonal('10021434');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2012'));
        $this->addReference('Personal-10021434', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('18644172');
        $personal->setNomPersonal('TORRES L , FERNANDO');
        $personal->setNumPersonal('10021493');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2012'));
        $this->addReference('Personal-10021493', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('643563');
        $personal->setNomPersonal('PALACIOS , RUBEN');
        $personal->setNumPersonal('10016660');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2012'));
        $this->addReference('Personal-10016660', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('13685662');
        $personal->setNomPersonal('PEÑALOZA L , VICTOR M');
        $personal->setNumPersonal('10017995');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2012'));
        $this->addReference('Personal-10017995', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('4826948');
        $personal->setNomPersonal('FERNANDEZ , ARNALDO J');
        $personal->setNumPersonal('10001768');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2013'));
        $this->addReference('Personal-10001768', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('4338769');
        $personal->setNomPersonal('MOROCOIMA B , JOSE G');
        $personal->setNumPersonal('10001359');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2013'));
        $this->addReference('Personal-10001359', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('5673366');
        $personal->setNomPersonal('FLORES , OMAR J');
        $personal->setNumPersonal('10002248');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2013'));
        $this->addReference('Personal-10002248', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('6813216');
        $personal->setNomPersonal('GARCIA M , MARCO A');
        $personal->setNumPersonal('10002603');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2013'));
        $this->addReference('Personal-10002603', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('15168893');
        $personal->setNomPersonal('LICERIO Q , IVIS Y');
        $personal->setNumPersonal('10017906');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2013'));
        $this->addReference('Personal-10017906', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('9344317');
        $personal->setNomPersonal('PEREZ , BENIGNO');
        $personal->setNumPersonal('10007733');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2013'));
        $this->addReference('Personal-10007733', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('10509000');
        $personal->setNomPersonal('GARCIA CH , LUIS DEL V');
        $personal->setNumPersonal('10012710');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2013'));
        $this->addReference('Personal-10012710', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('17027639');
        $personal->setNomPersonal('MENDOZA , RAMON E');
        $personal->setNumPersonal('10017346');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2013'));
        $this->addReference('Personal-10017346', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('9662388');
        $personal->setNomPersonal('GARCIA C , FRED G');
        $personal->setNumPersonal('10019736');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2013'));
        $this->addReference('Personal-10019736', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('9439186');
        $personal->setNomPersonal('ROMERO S , JORGE L');
        $personal->setNumPersonal('10017904');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2013'));
        $this->addReference('Personal-10017904', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('7148499');
        $personal->setNomPersonal('OJEDA H , PABLO A');
        $personal->setNumPersonal('10021691');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2013'));
        $this->addReference('Personal-10021691', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('15008860');
        $personal->setNomPersonal('LASORSA A , JOSE E');
        $personal->setNumPersonal('10020480');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2013'));
        $this->addReference('Personal-10020480', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('8759143');
        $personal->setNomPersonal('ACOSTA M , CARLOS J');
        $personal->setNumPersonal('10003579');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2013'));
        $this->addReference('Personal-10003579', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('11283360');
        $personal->setNomPersonal('RANGEL A , REINALDO A');
        $personal->setNumPersonal('10019812');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2013'));
        $this->addReference('Personal-10019812', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('11507075');
        $personal->setNomPersonal('DOMADOR D , PEDRO J.');
        $personal->setNumPersonal('10020778');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2013'));
        $this->addReference('Personal-10020778', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('14708395');
        $personal->setNomPersonal('ATACHO S , LEANDRO J');
        $personal->setNumPersonal('10020782');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2013'));
        $this->addReference('Personal-10020782', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('16259019');
        $personal->setNomPersonal('GARBOZA O , ROBER A');
        $personal->setNumPersonal('10021496');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2013'));
        $this->addReference('Personal-10021496', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('17013369');
        $personal->setNomPersonal('VARGAS P , PEDRO L');
        $personal->setNumPersonal('10021464');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2013'));
        $this->addReference('Personal-10021464', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('17941891');
        $personal->setNomPersonal('ALVAREZ P , JULIO A');
        $personal->setNumPersonal('10021457');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2013'));
        $this->addReference('Personal-10021457', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('5752340');
        $personal->setNomPersonal('PETIT G , ALEXIS J');
        $personal->setNumPersonal('10017049');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2013'));
        $this->addReference('Personal-10017049', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('4293525');
        $personal->setNomPersonal('OLIVIER , ANTONIO J');
        $personal->setNumPersonal('10001335');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2013'));
        $this->addReference('Personal-10001335', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('6114449');
        $personal->setNomPersonal('HERNANDEZ , NOVIRGEL G');
        $personal->setNumPersonal('10002475');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2013'));
        $this->addReference('Personal-10002475', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('8709872');
        $personal->setNomPersonal('NOGUERA Q , LUIS F');
        $personal->setNumPersonal('10005659');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2013'));
        $this->addReference('Personal-10005659', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('5543621');
        $personal->setNomPersonal('VARELA R , JOSE R');
        $personal->setNumPersonal('10012759');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2013'));
        $this->addReference('Personal-10012759', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('17989191');
        $personal->setNomPersonal('HERNANDEZ B. , WILLIAM J');
        $personal->setNumPersonal('10020780');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2013'));
        $this->addReference('Personal-10020780', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('16208190');
        $personal->setNomPersonal('RODRIGUEZ B , JHON M');
        $personal->setNumPersonal('10021827');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2013'));
        $this->addReference('Personal-10021827', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('7444352');
        $personal->setNomPersonal('VASQUEZ M , OMAR J');
        $personal->setNumPersonal('10019749');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2013'));
        $this->addReference('Personal-10019749', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('16597512');
        $personal->setNomPersonal('ROSENDO D , LISAURA B');
        $personal->setNumPersonal('10024296');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2014'));
        $this->addReference('Personal-10024296', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('16960313');
        $personal->setNomPersonal('TORRES G , ANGELICA M');
        $personal->setNumPersonal('10020783');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2014'));
        $this->addReference('Personal-10020783', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('13422434');
        $personal->setNomPersonal('GARCIA T , LISBETH J');
        $personal->setNumPersonal('10015850');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2014'));
        $this->addReference('Personal-10015850', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('17679822');
        $personal->setNomPersonal('HERNANDEZ  T , ASTRID');
        $personal->setNumPersonal('10024247');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2015'));
        $this->addReference('Personal-10024247', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('3836999');
        $personal->setNomPersonal('AGUIN M , ISABEL M');
        $personal->setNumPersonal('10021501');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2016'));
        $this->addReference('Personal-10021501', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('8703358');
        $personal->setNomPersonal('CHIRINOS O , JOSE L');
        $personal->setNumPersonal('10003568');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2017'));
        $this->addReference('Personal-10003568', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('8799592');
        $personal->setNomPersonal('MENDEZ , JOSE R');
        $personal->setNumPersonal('10019614');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2017'));
        $this->addReference('Personal-10019614', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('10376756');
        $personal->setNomPersonal('TACHON M , FRANKLIN A');
        $personal->setNumPersonal('10021849');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2018'));
        $this->addReference('Personal-10021849', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('13942304');
        $personal->setNomPersonal('PADRINO M , MARIA R');
        $personal->setNumPersonal('10017980');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2019'));
        $this->addReference('Personal-10017980', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('9001892');
        $personal->setNomPersonal('RANGEL , HENRRI J');
        $personal->setNumPersonal('10019839');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2020'));
        $this->addReference('Personal-10019839', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('10576651');
        $personal->setNomPersonal('ORTIZ S , ROMMER J');
        $personal->setNumPersonal('10017976');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2021'));
        $this->addReference('Personal-10017976', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('11090748');
        $personal->setNomPersonal('AGUIRRE A , ARGENIS A');
        $personal->setNumPersonal('10021804');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2022'));
        $this->addReference('Personal-10021804', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('6250513');
        $personal->setNomPersonal('CEDEÑO F , JOHNNY I');
        $personal->setNumPersonal('10017993');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2023'));
        $this->addReference('Personal-10017993', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('4587976');
        $personal->setNomPersonal('TREJO R , PRICILIA M');
        $personal->setNumPersonal('10019482');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2024'));
        $this->addReference('Personal-10019482', $personal);
            $manager->persist($personal);

        // gerencia 79

        $personal = new Personal();
        $personal->setCedula('14536202');
        $personal->setNomPersonal('CASTILLO U , GIOVANNA L');
        $personal->setNumPersonal('10019016');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2025'));
        $this->addReference('Personal-10019016', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('15481942');
        $personal->setNomPersonal('GONZALEZ  A. , JOSE   P.');
        $personal->setNumPersonal('10020462');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2025'));
        $this->addReference('Personal-10020462', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('11231431');
        $personal->setNomPersonal('ADRIAN V , JONATHAN J.');
        $personal->setNumPersonal('10020061');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2026'));
        $this->addReference('Personal-10020061', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('13510348');
        $personal->setNomPersonal('COLMENAREZ P , GAUDYBETH R');
        $personal->setNumPersonal('10019999');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2027'));
        $this->addReference('Personal-10019999', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('17394915');
        $personal->setNomPersonal('GUEDEZ L , NORWIS E');
        $personal->setNumPersonal('10017701');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2028'));
        $this->addReference('Personal-10017701', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('17014162');
        $personal->setNomPersonal('LEUNG F , YOHANA');
        $personal->setNumPersonal('10018516');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2029'));
        $this->addReference('Personal-10018516', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('18364136');
        $personal->setNomPersonal('MAGUIÑA B , JOSE A');
        $personal->setNumPersonal('10018922');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2029'));
        $this->addReference('Personal-10018922', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('13516820');
        $personal->setNomPersonal('ALVARADO G , DAVID R');
        $personal->setNumPersonal('10021906');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2030'));
        $this->addReference('Personal-10021906', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('13298404');
        $personal->setNomPersonal('IZQUIERDO T , MARYGHER DEL C');
        $personal->setNumPersonal('10018925');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2031'));
        $this->addReference('Personal-10018925', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('4867439');
        $personal->setNomPersonal('TORRES B , HECTOR A');
        $personal->setNumPersonal('10019832');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2032'));
        $this->addReference('Personal-10019832', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('13891435');
        $personal->setNomPersonal('BENITES P , ALBERTO J');
        $personal->setNumPersonal('10020277');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2033'));
        $this->addReference('Personal-10020277', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('11814405');
        $personal->setNomPersonal('CHAVEZ O , CARMEN I');
        $personal->setNumPersonal('10021125');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2034'));
        $this->addReference('Personal-10021125', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('12967929');
        $personal->setNomPersonal('MARQUEZ M , ANA C');
        $personal->setNumPersonal('10017744');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2035'));
        $this->addReference('Personal-10017744', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('13818630');
        $personal->setNomPersonal('MELENDEZ T , SIMON E');
        $personal->setNumPersonal('10021905');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2036'));
        $this->addReference('Personal-10021905', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('16318047');
        $personal->setNomPersonal('LEON T , JUAN F');
        $personal->setNumPersonal('10021702');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2037'));
        $this->addReference('Personal-10021702', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('15753687');
        $personal->setNomPersonal('NAVARRO A , XISMAR M');
        $personal->setNumPersonal('10021704');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2037'));
        $this->addReference('Personal-10021704', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('12534344');
        $personal->setNomPersonal('MORENO P , MAYRA A');
        $personal->setNumPersonal('10019391');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2037'));
        $this->addReference('Personal-10019391', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('16090627');
        $personal->setNomPersonal('LUCENA CH , KARLA M');
        $personal->setNumPersonal('10021687');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2037'));
        $this->addReference('Personal-10021687', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('13499083');
        $personal->setNomPersonal('GUZMAN G , XIOLYMAR');
        $personal->setNumPersonal('10016662');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2037'));
        $this->addReference('Personal-10016662', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('15260085');
        $personal->setNomPersonal('AVILA C , LEONER J');
        $personal->setNumPersonal('10015648');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2038'));
        $this->addReference('Personal-10015648', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('9688155');
        $personal->setNomPersonal('ESCALONA O , VICTOR J');
        $personal->setNumPersonal('10016012');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2039'));
        $this->addReference('Personal-10016012', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('15059269');
        $personal->setNomPersonal('GELVIS V , OSCAR J');
        $personal->setNumPersonal('10016691');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2040'));
        $this->addReference('Personal-10016691', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('14576275');
        $personal->setNomPersonal('ZERPA S , RICARDO M');
        $personal->setNumPersonal('10025358');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2041'));
        $this->addReference('Personal-10025358', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('14833643');
        $personal->setNomPersonal('FUENMAYOR S. , LUDAVI M.');
        $personal->setNumPersonal('10016285');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2041'));
        $this->addReference('Personal-10016285', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('8835283');
        $personal->setNomPersonal('CORDERO M , RAFAEL R');
        $personal->setNumPersonal('10016113');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2042'));
        $this->addReference('Personal-10016113', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('7561546');
        $personal->setNomPersonal('HERRERA G , JORGE L');
        $personal->setNumPersonal('10018599');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2042'));
        $this->addReference('Personal-10018599', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('12662155');
        $personal->setNomPersonal('ROJAS G , SOANNY D');
        $personal->setNumPersonal('10016663');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2043'));
        $this->addReference('Personal-10016663', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('7129263');
        $personal->setNomPersonal('HERNANDEZ C , JUAN C');
        $personal->setNumPersonal('10020367');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2043'));
        $this->addReference('Personal-10020367', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('11548728');
        $personal->setNomPersonal('CEBALLOS P , OSCAR S');
        $personal->setNumPersonal('10020772');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2044'));
        $this->addReference('Personal-10020772', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('12384073');
        $personal->setNomPersonal('FERNANDEZ A , EDUARDO J');
        $personal->setNumPersonal('10021845');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2044'));
        $this->addReference('Personal-10021845', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('16110261');
        $personal->setNomPersonal('GUEVARA DI , ANTONIO A');
        $personal->setNumPersonal('10020593');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2044'));
        $this->addReference('Personal-10020593', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('8107122');
        $personal->setNomPersonal('ROVIRA P , JOSE G');
        $personal->setNumPersonal('10022794');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2044'));
        $this->addReference('Personal-10022794', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('13666676');
        $personal->setNomPersonal('PACHECO S , LEANDRO J');
        $personal->setNumPersonal('10017536');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2044'));
        $this->addReference('Personal-10017536', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('9477466');
        $personal->setNomPersonal('TORRES V , YANEHT C');
        $personal->setNumPersonal('10021983');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2044'));
        $this->addReference('Personal-10021983', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('15258228');
        $personal->setNomPersonal('DIB P. , SAMIR C');
        $personal->setNumPersonal('10019915');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2045'));
        $this->addReference('Personal-10019915', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('8773338');
        $personal->setNomPersonal('PRIMERA B , MIRVIC DEL V');
        $personal->setNumPersonal('10015846');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2046'));
        $this->addReference('Personal-10015846', $personal);
            $manager->persist($personal);


        $personal = new Personal();
        $personal->setCedula('5539845');
        $personal->setNomPersonal('VELASQUEZ T , VIVIAN DEL C');
        $personal->setNumPersonal('10002207');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2047'));
        $this->addReference('Personal-10002207', $personal);
            $manager->persist($personal);

        // gerencia 

        $personal = new Personal();
        $personal->setCedula('18957224');
        $personal->setNomPersonal('PARAQUEIMO A , WUILMARY J');
        $personal->setNumPersonal('10020582');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2048'));
        $this->addReference('Personal-10020582', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('8719574');
        $personal->setNomPersonal('QUINTERO , ARELIS C');
        $personal->setNumPersonal('10022281');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2049'));
        $this->addReference('Personal-10022281', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('12102450');
        $personal->setNomPersonal('ABDOUCHE T , JOSE J');
        $personal->setNumPersonal('10017550');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2050'));
        $this->addReference('Personal-10017550', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('7166972');
        $personal->setNomPersonal('PALACIOS L , AMADO A');
        $personal->setNumPersonal('10013094');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2051'));
        $this->addReference('Personal-10013094', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('4808043');
        $personal->setNomPersonal('GUTIERREZ A , JOSE A');
        $personal->setNumPersonal('10021395');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2052'));
        $this->addReference('Personal-10021395', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('7167786');
        $personal->setNomPersonal('LORES , DILIA');
        $personal->setNumPersonal('10017322');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2053'));
        $this->addReference('Personal-10017322', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('14984720');
        $personal->setNomPersonal('GUTIERREZ P , MAYRA A');
        $personal->setNumPersonal('10021587');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2054'));
        $this->addReference('Personal-10021587', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('15880222');
        $personal->setNomPersonal('RUIZ M , BELKIS X');
        $personal->setNumPersonal('10021585');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2055'));
        $this->addReference('Personal-10021585', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('13601857');
        $personal->setNomPersonal('RODRIGUEZ F , JORGE A');
        $personal->setNumPersonal('10020044');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2055'));
        $this->addReference('Personal-10020044', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('11099264');
        $personal->setNomPersonal('SILVA S , ANNY J');
        $personal->setNumPersonal('10018965');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2056'));
        $this->addReference('Personal-10018965', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('14407194');
        $personal->setNomPersonal('PEREZ S , MERLY S');
        $personal->setNumPersonal('10021436');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2057'));
        $this->addReference('Personal-10021436', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('16301919');
        $personal->setNomPersonal('DUARTE B , JUAN P');
        $personal->setNumPersonal('10019620');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2058'));
        $this->addReference('Personal-10019620', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('14701234');
        $personal->setNomPersonal('RAMIREZ S , MARIAN C');
        $personal->setNumPersonal('10019860');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2059'));
        $this->addReference('Personal-10019860', $personal);
            $manager->persist($personal);

        // gerencia 81

        $personal = new Personal();
        $personal->setCedula('15494415');
        $personal->setNomPersonal('BAUTISTA P , ARGENIS A');
        $personal->setNumPersonal('10017333');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2060'));
        $this->addReference('Personal-10017333', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('15883443');
        $personal->setNomPersonal('PAZ R , JEOMARIS M');
        $personal->setNumPersonal('10020230');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2060'));
        $this->addReference('Personal-10020230', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('10350687');
        $personal->setNomPersonal('DELGADO F , ALEJANDRO A');
        $personal->setNumPersonal('10003887');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2060'));
        $this->addReference('Personal-10003887', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('9970512');
        $personal->setNomPersonal('MILLAN A , ANAILET C');
        $personal->setNumPersonal('10020078');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2061'));
        $this->addReference('Personal-10020078', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('7998629');
        $personal->setNomPersonal('LOPEZ S , SHEILA J');
        $personal->setNumPersonal('10021688');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2061'));
        $this->addReference('Personal-10021688', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('16273492');
        $personal->setNomPersonal('FERMIN DE LA C , NATHALIE DEL');
        $personal->setNumPersonal('10019424');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2061'));
        $this->addReference('Personal-10019424', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('10254940');
        $personal->setNomPersonal('VILORIA S , DAICY C');
        $personal->setNumPersonal('10016776');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2061'));
        $this->addReference('Personal-10016776', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('16569668');
        $personal->setNomPersonal('BARRIOS P , DEGLIS Y');
        $personal->setNumPersonal('10017210');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2062'));
        $this->addReference('Personal-10017210', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('12339809');
        $personal->setNomPersonal('CASTILLO P , ANA K');
        $personal->setNumPersonal('10023844');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2062'));
        $this->addReference('Personal-10023844', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('12037614');
        $personal->setNomPersonal('RAMONI C , ARLENY M');
        $personal->setNumPersonal('10018887');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2062'));
        $this->addReference('Personal-10018887', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('20289966');
        $personal->setNomPersonal('RAMIREZ V. , BEYLIG E.');
        $personal->setNumPersonal('10018510');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2062'));
        $this->addReference('Personal-10018510', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('19339316');
        $personal->setNomPersonal('GARCIA R , ALFREDO J');
        $personal->setNumPersonal('10024155');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2063'));
        $this->addReference('Personal-10024155', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('16022496');
        $personal->setNomPersonal('DELGADO G , NORMAN A');
        $personal->setNumPersonal('10019624');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2063'));
        $this->addReference('Personal-10019624', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('13955176');
        $personal->setNomPersonal('PEREIRA L , RICARDO N');
        $personal->setNumPersonal('10019382');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2064'));
        $this->addReference('Personal-10019382', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('22552591');
        $personal->setNomPersonal('CEDEÑO V , HUGO O');
        $personal->setNumPersonal('10021462');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2064'));
        $this->addReference('Personal-10021462', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('15258628');
        $personal->setNomPersonal('PUERTA C , FRANCISCO J');
        $personal->setNumPersonal('10021458');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2065'));
        $this->addReference('Personal-10021458', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('13956092');
        $personal->setNomPersonal('ROMERO B , JUAN C');
        $personal->setNumPersonal('10023577');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2066'));
        $this->addReference('Personal-10023577', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('15963119');
        $personal->setNomPersonal('BARRETO M , MOISES E');
        $personal->setNumPersonal('10018040');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2066'));
        $this->addReference('Personal-10018040', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('10116230');
        $personal->setNomPersonal('GARCIA M , WILMER J');
        $personal->setNumPersonal('10025192');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2066'));
        $this->addReference('Personal-10025192', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('15484785');
        $personal->setNomPersonal('SANCHEZ L , RICHARD F');
        $personal->setNumPersonal('10021601');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2066'));
        $this->addReference('Personal-10021601', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('10188598');
        $personal->setNomPersonal('PULGAR , CENITH S.');
        $personal->setNumPersonal('10024023');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2066'));
        $this->addReference('Personal-10024023', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('12563158');
        $personal->setNomPersonal('CALDERON O , GYPSON J');
        $personal->setNumPersonal('10015794');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2067'));
        $this->addReference('Personal-10015794', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('15305742');
        $personal->setNomPersonal('ZARATE S , RICARDO H');
        $personal->setNumPersonal('10017607');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2067'));
        $this->addReference('Personal-10017607', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('14248893');
        $personal->setNomPersonal('AGUIAR P , ROSA M');
        $personal->setNumPersonal('10017867');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2067'));
        $this->addReference('Personal-10017867', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('15333616');
        $personal->setNomPersonal('TRUJILLO F , JOHANA R');
        $personal->setNumPersonal('10017874');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2067'));
        $this->addReference('Personal-10017874', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('19476156');
        $personal->setNomPersonal('LEON F , LOANA J');
        $personal->setNumPersonal('10023962');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2067'));
        $this->addReference('Personal-10023962', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('4794452');
        $personal->setNomPersonal('GUIÑAN R , JESUS M');
        $personal->setNumPersonal('10016297');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2068'));
        $this->addReference('Personal-10016297', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('17807350');
        $personal->setNomPersonal('MARTINEZ G , RUBEN D');
        $personal->setNumPersonal('10019617');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2068'));
        $this->addReference('Personal-10019617', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('17515540');
        $personal->setNomPersonal('GOMEZ R , EDWAR R');
        $personal->setNumPersonal('10017611');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2068'));
        $this->addReference('Personal-10017611', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('16363502');
        $personal->setNomPersonal('CARRILLO  A , DARIANA  L');
        $personal->setNumPersonal('10021386');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2069'));
        $this->addReference('Personal-10021386', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('13985034');
        $personal->setNomPersonal('OCHOA C , FELIANA DEL V');
        $personal->setNumPersonal('10019629');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2069'));
        $this->addReference('Personal-10019629', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('15924981');
        $personal->setNomPersonal('JIMENEZ Z , JESUS E');
        $personal->setNumPersonal('10016812');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2069'));
        $this->addReference('Personal-10016812', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('14454483');
        $personal->setNomPersonal('MOSQUEDA , JOSE');
        $personal->setNumPersonal('10024109');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2070'));
        $this->addReference('Personal-10024109', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('16569691');
        $personal->setNomPersonal('CABRERA B , KARLA O');
        $personal->setNumPersonal('10016763');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2070'));
        $this->addReference('Personal-10016763', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('15405484');
        $personal->setNomPersonal('BOHORQUEZ N. , LAURA A.');
        $personal->setNumPersonal('10016231');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2071'));
        $this->addReference('Personal-10016231', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('8848156');
        $personal->setNomPersonal('VIRA P , JOSE');
        $personal->setNumPersonal('10016027');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2071'));
        $this->addReference('Personal-10016027', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('12440425');
        $personal->setNomPersonal('CARRILLO B , NATALI J');
        $personal->setNumPersonal('10018921');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2071'));
        $this->addReference('Personal-10018921', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('11617676');
        $personal->setNomPersonal('BRICEÑO C , LISEE D');
        $personal->setNumPersonal('10017052');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2071'));
        $this->addReference('Personal-10017052', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('18361287');
        $personal->setNomPersonal('PACHECO  V , YENNYFER  M');
        $personal->setNumPersonal('10021385');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2071'));
        $this->addReference('Personal-10021385', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('11909650');
        $personal->setNomPersonal('ROJAS G , MARIA A');
        $personal->setNumPersonal('10016657');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2071'));
        $this->addReference('Personal-10016657', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('5299072');
        $personal->setNomPersonal('GONZALEZ A , LUISA C');
        $personal->setNumPersonal('10020067');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2071'));
        $this->addReference('Personal-10020067', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('12695392');
        $personal->setNomPersonal('NAVARRO C , ALEXANDER A');
        $personal->setNumPersonal('10016201');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2072'));
        $this->addReference('Personal-10016201', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('16775829');
        $personal->setNomPersonal('GONZALEZ A , ARGENIS A');
        $personal->setNumPersonal('10017868');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2073'));
        $this->addReference('Personal-10017868', $personal);
            $manager->persist($personal);


        $personal = new Personal();
        $personal->setCedula('7091856');
        $personal->setNomPersonal('MARTIN R , ANTONIO A');
        $personal->setNumPersonal('10018030');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2073'));
        $this->addReference('Personal-10018030', $personal);
            $manager->persist($personal);


        $personal = new Personal();
        $personal->setCedula('6902970');
        $personal->setNomPersonal('MORENO J , CARLOS A');
        $personal->setNumPersonal('10017880');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2074'));
        $this->addReference('Personal-10017880', $personal);
            $manager->persist($personal);


        $personal = new Personal();
        $personal->setCedula('6917818');
        $personal->setNomPersonal('LINARES S , JOSE R');
        $personal->setNumPersonal('10020401');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2075'));
        $this->addReference('Personal-10020401', $personal);
            $manager->persist($personal);


        $personal = new Personal();
        $personal->setCedula('7106810');
        $personal->setNomPersonal('VILLARROEL G , JOSE O');
        $personal->setNumPersonal('10017358');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2076'));
        $this->addReference('Personal-10017358', $personal);
            $manager->persist($personal);


        $personal = new Personal();
        $personal->setCedula('13754536');
        $personal->setNomPersonal('BALLAN R , SANAA S');
        $personal->setNumPersonal('10023657');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2077'));
        $this->addReference('Personal-10023657', $personal);
            $manager->persist($personal);


        $personal = new Personal();
        $personal->setCedula('13548930');
        $personal->setNomPersonal('DUNO F , ALEXIS M');
        $personal->setNumPersonal('10020226');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2078'));
        $this->addReference('Personal-10020226', $personal);
            $manager->persist($personal);


        $personal = new Personal();
        $personal->setCedula('14831332');
        $personal->setNomPersonal('PIRELA  F , ALEX  L');
        $personal->setNumPersonal('10019660');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2079'));
        $this->addReference('Personal-10019660', $personal);
            $manager->persist($personal);


        $personal = new Personal();
        $personal->setCedula('12606661');
        $personal->setNomPersonal('ARIAS A , RICHARD A');
        $personal->setNumPersonal('10019618');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2079'));
        $this->addReference('Personal-10019618', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('7173728');
        $personal->setNomPersonal('AVINZANO G , FELIPE');
        $personal->setNumPersonal('10019814');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2080'));
        $this->addReference('Personal-10019814', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('11979067');
        $personal->setNomPersonal('BENDA G , MAHILETH D');
        $personal->setNumPersonal('10024299');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2081'));
        $this->addReference('Personal-10024299', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('11586369');
        $personal->setNomPersonal('PEREZ R , ISILROBERT J');
        $personal->setNumPersonal('10017883');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2082'));
        $this->addReference('Personal-10017883', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('8807893');
        $personal->setNomPersonal('MARTINEZ M , JOSE G');
        $personal->setNumPersonal('10016163');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2083'));
        $this->addReference('Personal-10016163', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('14176552');
        $personal->setNomPersonal('FIGUEREDO L , LUIS A');
        $personal->setNumPersonal('10017421');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2084'));
        $this->addReference('Personal-10017421', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('14701137');
        $personal->setNomPersonal('MEDINA P , LAURA T');
        $personal->setNumPersonal('10017865');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2085'));
        $this->addReference('Personal-10017865', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('7130861');
        $personal->setNomPersonal('MADDIA R , JAVIER E');
        $personal->setNumPersonal('10016026');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2086'));
        $this->addReference('Personal-10016026', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('13336768');
        $personal->setNomPersonal('SANTANA S , JESUS F');
        $personal->setNumPersonal('10019639');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2087'));
        $this->addReference('Personal-10019639', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('9968586');
        $personal->setNomPersonal('SERRANO G , JOHNNY E');
        $personal->setNumPersonal('10015796');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2088'));
        $this->addReference('Personal-10015796', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('9828197');
        $personal->setNomPersonal('MERIDA  A , MANUEL  E');
        $personal->setNumPersonal('10020554');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2089'));
        $this->addReference('Personal-10020554', $personal);
            $manager->persist($personal);

        // gerencia 82

        $personal = new Personal();
        $personal->setCedula('14871475');
        $personal->setNomPersonal('MONTENEGRO P , JENNYFER');
        $personal->setNumPersonal('10019792');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2090'));
        $this->addReference('Personal-10019792', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('11812867');
        $personal->setNomPersonal('GOMEZ M. , GABRIELA A.');
        $personal->setNumPersonal('10024530');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2091'));
        $this->addReference('Personal-10024530', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('19387566');
        $personal->setNomPersonal('VEGAS T , JHONNY E');
        $personal->setNumPersonal('10020958');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2092'));
        $this->addReference('Personal-10020958', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('13193026');
        $personal->setNomPersonal('RODRIGUEZ E , TEOBALDO E');
        $personal->setNumPersonal('10020116');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2093'));
        $this->addReference('Personal-10020116', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('13614900');
        $personal->setNomPersonal('LOPEZ L , GREICYS A');
        $personal->setNumPersonal('10019787');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2094'));
        $this->addReference('Personal-10019787', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('17399606');
        $personal->setNomPersonal('LEVINSON C , ROSA M');
        $personal->setNumPersonal('10020670');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2095'));
        $this->addReference('Personal-10020670', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('4283456');
        $personal->setNomPersonal('SALAS J , LUIS F');
        $personal->setNumPersonal('10019760');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2096'));
        $this->addReference('Personal-10019760', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('11160221');
        $personal->setNomPersonal('ALVAREZ S , MIRASI');
        $personal->setNumPersonal('10019178');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2097'));
        $this->addReference('Personal-10019178', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('24208837');
        $personal->setNomPersonal('ARENAS M , SERGIO L');
        $personal->setNumPersonal('10019165');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2098'));
        $this->addReference('Personal-10019165', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('13192683');
        $personal->setNomPersonal('MATA  C. , GERALDINE S.');
        $personal->setNumPersonal('10019735');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2099'));
        $this->addReference('Personal-10019735', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('18362449');
        $personal->setNomPersonal('LUGO R , ADRIANA A');
        $personal->setNumPersonal('10019880');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2100'));
        $this->addReference('Personal-10019880', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('5133327');
        $personal->setNomPersonal('VIDAL H , SONIA M');
        $personal->setNumPersonal('10001970');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2101'));
        $this->addReference('Personal-10001970', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('11645026');
        $personal->setNomPersonal('MARTINEZ P , MERY C');
        $personal->setNumPersonal('10021463');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2102'));
        $this->addReference('Personal-10021463', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('16596561');
        $personal->setNomPersonal('GUDIÑO L , YESENIA');
        $personal->setNumPersonal('10019864');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2103'));
        $this->addReference('Personal-10019864', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('12495281');
        $personal->setNomPersonal('GARCES , MERLYS C');
        $personal->setNumPersonal('10023225');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2104'));
        $this->addReference('Personal-10023225', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('14548724');
        $personal->setNomPersonal('OSAL U , ANDREA C');
        $personal->setNumPersonal('10020909');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2105'));
        $this->addReference('Personal-10020909', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('17067328');
        $personal->setNomPersonal('MINGUET P , ALEXANDRA M');
        $personal->setNumPersonal('10023802');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2106'));
        $this->addReference('Personal-10023802', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('14702621');
        $personal->setNomPersonal('GARCIA M. , FRANCISCO A.');
        $personal->setNumPersonal('10020788');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2107'));
        $this->addReference('Personal-10020788', $personal);
            $manager->persist($personal);



        // gerencia 83

        $personal = new Personal();
        $personal->setCedula('17427108');
        $personal->setNomPersonal('EDUARDO R , EGLIS J');
        $personal->setNumPersonal('10021027');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2108'));
        $this->addReference('Personal-10021027', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('9566372');
        $personal->setNomPersonal('SEGOVIA G , YADIRA DEL C');
        $personal->setNumPersonal('10019577');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2109'));
        $this->addReference('Personal-10019577', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('12923542');
        $personal->setNomPersonal('CEDEÑO G , ALEXANDRA  A');
        $personal->setNumPersonal('10019174');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2110'));
        $this->addReference('Personal-10019174', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('13790993');
        $personal->setNomPersonal('LOZANO B , MARTHA L');
        $personal->setNumPersonal('10018816');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2111'));
        $this->addReference('Personal-10018816', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('11362136');
        $personal->setNomPersonal('BAUTE H , YURIMA K');
        $personal->setNumPersonal('10021366');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2111'));
        $this->addReference('Personal-10021366', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('17001629');
        $personal->setNomPersonal('MORAN A , MICHELLE');
        $personal->setNumPersonal('10017332');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2111'));
        $this->addReference('Personal-10017332', $personal);
            $manager->persist($personal);


        $personal = new Personal();
        $personal->setCedula('5758753');
        $personal->setNomPersonal('FERNANDEZ P , CARLOS L');
        $personal->setNumPersonal('10021190');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2112'));
        $this->addReference('Personal-10021190', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('9645276');
        $personal->setNomPersonal('ACOSTA M , ENDER J');
        $personal->setNumPersonal('10021625');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2112'));
        $this->addReference('Personal-10021625', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('12088884');
        $personal->setNomPersonal('MENDEZ M , YALIMAR L');
        $personal->setNumPersonal('10019225');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2112'));
        $this->addReference('Personal-10019225', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('14536110');
        $personal->setNomPersonal('ARVELO P , LUZBENIA G');
        $personal->setNumPersonal('10018736');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2112'));
        $this->addReference('Personal-10018736', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('11368123');
        $personal->setNomPersonal('CASTILLO R , OSWALDO J');
        $personal->setNumPersonal('10019180');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2113'));
        $this->addReference('Personal-10019180', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('17628296');
        $personal->setNomPersonal('DIAZ G , ROSA E');
        $personal->setNumPersonal('10019757');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2113'));
        $this->addReference('Personal-10019757', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('10072711');
        $personal->setNomPersonal('FAJARDO S , JAVIER F');
        $personal->setNumPersonal('10018831');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2114'));
        $this->addReference('Personal-10018831', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('12754164');
        $personal->setNomPersonal('FLORES F , FRANCIS L');
        $personal->setNumPersonal('10020806');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2115'));
        $this->addReference('Personal-10020806', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('15419499');
        $personal->setNomPersonal('RAMOS H , FLORANGEL J');
        $personal->setNumPersonal('10018880');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2115'));
        $this->addReference('Personal-10018880', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('4869639');
        $personal->setNomPersonal('BLANCO L , JOSE R');
        $personal->setNumPersonal('10019835');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2116'));
        $this->addReference('Personal-10019835', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('12798144');
        $personal->setNomPersonal('RUIZ P , GRISSETT T');
        $personal->setNumPersonal('10019816');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2116'));
        $this->addReference('Personal-10019816', $personal);
            $manager->persist($personal);


        $personal = new Personal();
        $personal->setCedula('15610515');
        $personal->setNomPersonal('OSIO V , SOFIA');
        $personal->setNumPersonal('10021124');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2117'));
        $this->addReference('Personal-10021124', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('15849988');
        $personal->setNomPersonal('BRACHO R , MARY A');
        $personal->setNumPersonal('10015181');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2118'));
        $this->addReference('Personal-10015181', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('15407920');
        $personal->setNomPersonal('TORREALBA P , MARCELO R');
        $personal->setNumPersonal('10022785');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2119'));
        $this->addReference('Personal-10022785', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('10803080');
        $personal->setNomPersonal('OBREGON M , YELITZE DEL V');
        $personal->setNumPersonal('10018514');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2120'));
        $this->addReference('Personal-10018514', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('10310902');
        $personal->setNomPersonal('LUQUE Q , JESUS A');
        $personal->setNumPersonal('10020229');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2120'));
        $this->addReference('Personal-10020229', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('14889137');
        $personal->setNomPersonal('CORDOVA G , CARMEN V');
        $personal->setNumPersonal('10017283');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2121'));
        $this->addReference('Personal-10017283', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('10519105');
        $personal->setNomPersonal('FANDIÑO D , ALEXIS R');
        $personal->setNumPersonal('10023578');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2122'));
        $this->addReference('Personal-10023578', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('11147798');
        $personal->setNomPersonal('GIRÓN L , EVIMAR V');
        $personal->setNumPersonal('10019833');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2122'));
        $this->addReference('Personal-10019833', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('14302973');
        $personal->setNomPersonal('MARTINEZ H , DAYANA R');
        $personal->setNumPersonal('10018903');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2123'));
        $this->addReference('Personal-10018903', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('16133288');
        $personal->setNomPersonal('TRISTANCHO G , LUIS A');
        $personal->setNumPersonal('10021025');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2123'));
        $this->addReference('Personal-10021025', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('16957438');
        $personal->setNomPersonal('DIAZ P , MARYORI DEL C');
        $personal->setNumPersonal('10020469');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2123'));
        $this->addReference('Personal-10020469', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('16965218');
        $personal->setNomPersonal('PARRA C , LEIDERT Y');
        $personal->setNumPersonal('10019208');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2123'));
        $this->addReference('Personal-10019208', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('14971654');
        $personal->setNomPersonal('SOSA S , RAFAEL J');
        $personal->setNumPersonal('10023294');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2123'));
        $this->addReference('Personal-10023294', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('18490881');
        $personal->setNomPersonal('LATHULERIE F , BELICE');
        $personal->setNumPersonal('10023071');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2124'));
        $this->addReference('Personal-10023071', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('14025252');
        $personal->setNomPersonal('RIVAS P , DAYANA C');
        $personal->setNumPersonal('10016696');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2125'));
        $this->addReference('Personal-10016696', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('16201565');
        $personal->setNomPersonal('SALAZAR L , VICTORIA J S');
        $personal->setNumPersonal('10019800');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2126'));
        $this->addReference('Personal-10019800', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('13548935');
        $personal->setNomPersonal('CORNIEL H , ANNA K');
        $personal->setNumPersonal('10020317');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2126'));
        $this->addReference('Personal-10020317', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('15153931');
        $personal->setNomPersonal('REQUENA P , RONALD E');
        $personal->setNumPersonal('10018305');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2127'));
        $this->addReference('Personal-10018305', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('7722207');
        $personal->setNomPersonal('MARTINEZ V , ALBERT DE J');
        $personal->setNumPersonal('10016222');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2128'));
        $this->addReference('Personal-10016222', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('6750561');
        $personal->setNomPersonal('PARRAGA R , RAFAEL J');
        $personal->setNumPersonal('10016648');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2129'));
        $this->addReference('Personal-10016648', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('3604928');
        $personal->setNomPersonal('ZAMBRANO R , HECTOR O');
        $personal->setNumPersonal('10019654');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2130'));
        $this->addReference('Personal-10019654', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('9995813');
        $personal->setNomPersonal('MORENO R , FRANCISCO J');
        $personal->setNumPersonal('10015716');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2131'));
        $this->addReference('Personal-10015716', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('16941731');
        $personal->setNomPersonal('COLINA G , ELIALIS C');
        $personal->setNumPersonal('10018494');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2132'));
        $this->addReference('Personal-10018494', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('6728208');
        $personal->setNomPersonal('GONZALEZ G , SUSANA M');
        $personal->setNumPersonal('10002589');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2133'));
        $this->addReference('Personal-10002589', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('10333741');
        $personal->setNomPersonal('MARTINEZ N , JULIO C');
        $personal->setNumPersonal('10016645');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2134'));
        $this->addReference('Personal-10016645', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('12046529');
        $personal->setNomPersonal('FERNANDEZ DE S , LISBETH Y');
        $personal->setNumPersonal('10015750');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2135'));
        $this->addReference('Personal-10015750', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('7123032');
        $personal->setNomPersonal('BOUZA C , INDGAR T');
        $personal->setNumPersonal('10017327');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2136'));
        $this->addReference('Personal-10017327', $personal);
            $manager->persist($personal);


        $personal = new Personal();
        $personal->setCedula('14707148');
        $personal->setNomPersonal('OLIVEROS A , EDITZA DE LOS A');
        $personal->setNumPersonal('10015707');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2137'));
        $this->addReference('Personal-10015707', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('5071441');
        $personal->setNomPersonal('CASTILLO R , ANDRES R');
        $personal->setNumPersonal('10004527');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2138'));
        $this->addReference('Personal-10004527', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('9964126');
        $personal->setNomPersonal('MORO A , LILIANA DEL C');
        $personal->setNumPersonal('10019917');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2139'));
        $this->addReference('Personal-10019917', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('12093890');
        $personal->setNomPersonal('PESTANA A , SUSANA');
        $personal->setNumPersonal('10016666');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2140'));
        $this->addReference('Personal-10016666', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('15147305');
        $personal->setNomPersonal('ALMENAR M , ANA Y');
        $personal->setNumPersonal('10021185');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2141'));
        $this->addReference('Personal-10021185', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('6491871');
        $personal->setNomPersonal('ROVAINA D , ROSA D');
        $personal->setNumPersonal('10017482');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2142'));
        $this->addReference('Personal-10017482', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('12746386');
        $personal->setNomPersonal('CASTILLO L , RAMON A');
        $personal->setNumPersonal('10015498');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2143'));
        $this->addReference('Personal-10015498', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('13126552');
        $personal->setNomPersonal('PALACIOS G. , YELITZA A.');
        $personal->setNumPersonal('10015799');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2144'));
        $this->addReference('Personal-10015799', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('16691732');
        $personal->setNomPersonal('MEDINA P , MARIA DE LOS A.');
        $personal->setNumPersonal('10021703');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2145'));
        $this->addReference('Personal-10021703', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('13842919');
        $personal->setNomPersonal('MADURO OROPEZA , EVAMARINA');
        $personal->setNumPersonal('10019798');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2146'));
        $this->addReference('Personal-10019798', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('11161076');
        $personal->setNomPersonal('ALVAREZ S , RAFAEL S');
        $personal->setNumPersonal('10017020');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2147'));
        $this->addReference('Personal-10017020', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('11900605');
        $personal->setNomPersonal('CHACON C , NUBIMAR T');
        $personal->setNumPersonal('10015513');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2148'));
        $this->addReference('Personal-10015513', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('13307109');
        $personal->setNomPersonal('RIVAS P , JENNY A');
        $personal->setNumPersonal('10016629');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2149'));
        $this->addReference('Personal-10016629', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('15039502');
        $personal->setNomPersonal('DOMINGUEZ D , DESIREE D');
        $personal->setNumPersonal('10020472');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2150'));
        $this->addReference('Personal-10020472', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('13765033');
        $personal->setNomPersonal('MENDOZA R , YUSMARY');
        $personal->setNumPersonal('10021420');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2151'));
        $this->addReference('Personal-10021420', $personal);
            $manager->persist($personal);

        // gerencia 84

        $personal = new Personal();
        $personal->setCedula('11527066');
        $personal->setNomPersonal('GONZALEZ B , DORIS C');
        $personal->setNumPersonal('10023970');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2152'));
        $this->addReference('Personal-10023970', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('8580775');
        $personal->setNomPersonal('ARIAS M , GRICELDYS M');
        $personal->setNumPersonal('10017810');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2153'));
        $this->addReference('Personal-10017810', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('16049474');
        $personal->setNomPersonal('GERVIS B , JANYS J');
        $personal->setNumPersonal('10022417');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2154'));
        $this->addReference('Personal-10022417', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('12990608');
        $personal->setNomPersonal('ARTEAGA V , MARIUXI DEL C');
        $personal->setNumPersonal('10021459');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2155'));
        $this->addReference('Personal-10021459', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('9663632');
        $personal->setNomPersonal('LEON H , LUIS M');
        $personal->setNumPersonal('10023830');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2155'));
        $this->addReference('Personal-10023830', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('10974307');
        $personal->setNomPersonal('CASTILLO A , YEANNETTE C');
        $personal->setNumPersonal('10024049');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2155'));
        $this->addReference('Personal-10024049', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('17024088');
        $personal->setNomPersonal('GARBAN C , LISBETH DEL C');
        $personal->setNumPersonal('10023414');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2155'));
        $this->addReference('Personal-10023414', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('8027913');
        $personal->setNomPersonal('PEÑA S , ERMINDA');
        $personal->setNumPersonal('10003368');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2156'));
        $this->addReference('Personal-10003368', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('16569683');
        $personal->setNomPersonal('GARCIA C , MADELIN B');
        $personal->setNumPersonal('10019699');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2157'));
        $this->addReference('Personal-10019699', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('21238349');
        $personal->setNomPersonal('LOPEZ R , YOHANI W');
        $personal->setNumPersonal('10024821');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2157'));
        $this->addReference('Personal-10024821', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('16154536');
        $personal->setNomPersonal('NOGUERA A , MARIA C');
        $personal->setNumPersonal('10020544');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2157'));
        $this->addReference('Personal-10020544', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('14389327');
        $personal->setNomPersonal('PACHECO S , FEDERICA E');
        $personal->setNumPersonal('10019286');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2158'));
        $this->addReference('Personal-10019286', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('7013169');
        $personal->setNomPersonal('OLIVO Z , GEORGINA');
        $personal->setNumPersonal('10019081');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2159'));
        $this->addReference('Personal-10019081', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('8242913');
        $personal->setNomPersonal('GUARARIMA F , ADILIA M');
        $personal->setNumPersonal('10003393');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2160'));
        $this->addReference('Personal-10003393', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('4135901');
        $personal->setNomPersonal('SOCHACKYJ S , GLEN J');
        $personal->setNumPersonal('10019625');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2161'));
        $this->addReference('Personal-10019625', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('8596079');
        $personal->setNomPersonal('APONTE P , LEONOR M');
        $personal->setNumPersonal('10023416');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2162'));
        $this->addReference('Personal-10023416', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('14829481');
        $personal->setNomPersonal('GARCIA J , JENNY L');
        $personal->setNumPersonal('10023415');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2163'));
        $this->addReference('Personal-10023415', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('12502479');
        $personal->setNomPersonal('TORRES B , LUISSANA A');
        $personal->setNumPersonal('10021431');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2164'));
        $this->addReference('Personal-10021431', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('7132526');
        $personal->setNomPersonal('KHURKOUT DE L , SALMA');
        $personal->setNumPersonal('10019701');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2165'));
        $this->addReference('Personal-10019701', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('14923169');
        $personal->setNomPersonal('IRIARTE P , YELITZA C');
        $personal->setNumPersonal('10017253');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2166'));
        $this->addReference('Personal-10017253', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('10447498');
        $personal->setNomPersonal('DIAZ M , LETICIA F');
        $personal->setNumPersonal('10017436');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2167'));
        $this->addReference('Personal-10017436', $personal);
            $manager->persist($personal);

        // gerencia 85

        $personal = new Personal();
        $personal->setCedula('13178510');
        $personal->setNomPersonal('URBAEZ  V , LUISA  L');
        $personal->setNumPersonal('10020427');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2168'));
        $this->addReference('Personal-10020427', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('25754094');
        $personal->setNomPersonal('MARTINEZ A , KARINE');
        $personal->setNumPersonal('10021783');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2169'));
        $this->addReference('Personal-10021783', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('17127260');
        $personal->setNomPersonal('RODRIGUEZ M , JOSE A');
        $personal->setNumPersonal('10020974');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2169'));
        $this->addReference('Personal-10020974', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('8478101');
        $personal->setNomPersonal('VIELMA R. , LOURDES DEL V.');
        $personal->setNumPersonal('10020580');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2170'));
        $this->addReference('Personal-10020580', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('8499195');
        $personal->setNomPersonal('SALAS C , LUIS E');
        $personal->setNumPersonal('10021632');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2171'));
        $this->addReference('Personal-10021632', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('4406043');
        $personal->setNomPersonal('ALFONZO , JOSE M');
        $personal->setNumPersonal('10017313');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2172'));
        $this->addReference('Personal-10017313', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('5890790');
        $personal->setNomPersonal('KADI B , NABIL');
        $personal->setNumPersonal('10017230');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2173'));
        $this->addReference('Personal-10017230', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('7078573');
        $personal->setNomPersonal('RIOS P. , LEONARDO B.');
        $personal->setNumPersonal('10024316');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2174'));
        $this->addReference('Personal-10024316', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('13448427');
        $personal->setNomPersonal('MARQUEZ P , DANIEL E');
        $personal->setNumPersonal('10020572');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2175'));
        $this->addReference('Personal-10020572', $personal);
            $manager->persist($personal);

        // gerencia 86

        $personal = new Personal();
        $personal->setCedula('10632296');
        $personal->setNomPersonal('ROMERO M , ARGENIS E');
        $personal->setNumPersonal('10021588');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2176'));
        $this->addReference('Personal-10021588', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('14978949');
        $personal->setNomPersonal('GONZALEZ CH , ROSELYN M');
        $personal->setNumPersonal('10019743');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2176'));
        $this->addReference('Personal-10019743', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('13962913');
        $personal->setNomPersonal('MELENDEZ G , CARMEN');
        $personal->setNumPersonal('10025214');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2176'));
        $this->addReference('Personal-10025214', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('18083518');
        $personal->setNomPersonal('TORREALBA G , JESUS A');
        $personal->setNumPersonal('10019836');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2177'));
        $this->addReference('Personal-10019836', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('13661916');
        $personal->setNomPersonal('LOAIZA C , ALEJANDRA M');
        $personal->setNumPersonal('10021184');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2177'));
        $this->addReference('Personal-10021184', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('8788050');
        $personal->setNomPersonal('HURTADO S , YELANDY DEL R');
        $personal->setNumPersonal('10021523');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2177'));
        $this->addReference('Personal-10021523', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('4054805');
        $personal->setNomPersonal('DIAZ  R , CARLOS M');
        $personal->setNumPersonal('10019276');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2178'));
        $this->addReference('Personal-10019276', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('10665659');
        $personal->setNomPersonal('IGLESIAS M , THANIA');
        $personal->setNumPersonal('10021469');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2179'));
        $this->addReference('Personal-10021469', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('7414094');
        $personal->setNomPersonal('ROMERO H , MARTHA E');
        $personal->setNumPersonal('10019734');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2180'));
        $this->addReference('Personal-10019734', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('12258951');
        $personal->setNomPersonal('TUA T , ZWELKY M');
        $personal->setNumPersonal('10016168');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2181'));
        $this->addReference('Personal-10016168', $personal);
            $manager->persist($personal);

        // gerencia 87

        $personal = new Personal();
        $personal->setCedula('10434962');
        $personal->setNomPersonal('SOTILLO B , IVAN D');
        $personal->setNumPersonal('10019355');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2182'));
        $this->addReference('Personal-10019355', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('14850752');
        $personal->setNomPersonal('PERAZA A , ALBERT J');
        $personal->setNumPersonal('10020972');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2183'));
        $this->addReference('Personal-10020972', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('8834561');
        $personal->setNomPersonal('GUERRERO B , GIOVANNI O');
        $personal->setNumPersonal('10021692');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2184'));
        $this->addReference('Personal-10021692', $personal);
            $manager->persist($personal);

        // gerencia 88

        $personal = new Personal();
        $personal->setCedula('5964676');
        $personal->setNomPersonal('MEJIAS R , FRANCISCO O');
        $personal->setNumPersonal('10019742');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2185'));
        $this->addReference('Personal-10019742', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('4356117');
        $personal->setNomPersonal('CASAÑAS A , EDUARDO E');
        $personal->setNumPersonal('10017408');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2186'));
        $this->addReference('Personal-10017408', $personal);
            $manager->persist($personal);

        // gerencia 89

        $personal = new Personal();
        $personal->setCedula('4249528');
        $personal->setNomPersonal('MENDEZ , JOSE E');
        $personal->setNumPersonal('10001320');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2187'));
        $this->addReference('Personal-10001320', $personal);
            $manager->persist($personal);


        $personal = new Personal();
        $personal->setCedula('7122737');
        $personal->setNomPersonal('AMELIACH L. , HERIBERTO A.');
        $personal->setNumPersonal('10016136');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2188'));
        $this->addReference('Personal-10016136', $personal);
            $manager->persist($personal);


        $personal = new Personal();
        $personal->setCedula('14446918');
        $personal->setNomPersonal('RANGEL S , JEAN C');
        $personal->setNumPersonal('10017423');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2189'));
        $this->addReference('Personal-10017423', $personal);
            $manager->persist($personal);


        $personal = new Personal();
        $personal->setCedula('14331985');
        $personal->setNomPersonal('BARAZARTE P , CHRISTIAN J');
        $personal->setNumPersonal('10020655');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2190'));
        $this->addReference('Personal-10020655', $personal);
            $manager->persist($personal);


        $personal = new Personal();
        $personal->setCedula('8611700');
        $personal->setNomPersonal('PARRA S , ORLANDO A');
        $personal->setNumPersonal('10020501');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2191'));
        $this->addReference('Personal-10020501', $personal);
            $manager->persist($personal);


        $personal = new Personal();
        $personal->setCedula('6727185');
        $personal->setNomPersonal('VIDAL H , ESPERANZA DEL C');
        $personal->setNumPersonal('10015947');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2192'));
        $this->addReference('Personal-10015947', $personal);
            $manager->persist($personal);


        $personal = new Personal();
        $personal->setCedula('4810216');
        $personal->setNomPersonal('MENDOZA , JOSE I');
        $personal->setNumPersonal('10019464');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2193'));
        $this->addReference('Personal-10019464', $personal);
            $manager->persist($personal);


        $personal = new Personal();
        $personal->setCedula('14952391');
        $personal->setNomPersonal('GUERRERO C , JAIRO');
        $personal->setNumPersonal('10019470');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2193'));
        $this->addReference('Personal-10019470', $personal);
            $manager->persist($personal);


        $personal = new Personal();
        $personal->setCedula('10993387');
        $personal->setNomPersonal('PINEDA R , OSWALDO A');
        $personal->setNumPersonal('10025540');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2193'));
        $this->addReference('Personal-10025540', $personal);
            $manager->persist($personal);

        $personal = new Personal();
        $personal->setCedula('14469328');
        $personal->setNomPersonal('STRAUSS R , ROSIBEL DEL C');
        $personal->setNumPersonal('10017908');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2194'));
        $this->addReference('Personal-10017908', $personal);
            $manager->persist($personal);


        $personal = new Personal();
        $personal->setCedula('10253564');
        $personal->setNomPersonal('MARTINEZ M , YALEXZY M');
        $personal->setNumPersonal('10020414');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2194'));
        $this->addReference('Personal-10020414', $personal);
            $manager->persist($personal);


        $personal = new Personal();
        $personal->setCedula('10697719');
        $personal->setNomPersonal('RONDON L , LEOMAR L');
        $personal->setNumPersonal('10017251');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2194'));
        $this->addReference('Personal-10017251', $personal);
            $manager->persist($personal);


        $personal = new Personal();
        $personal->setCedula('4165178');
        $personal->setNomPersonal('ROA R , VIRGINIA DEL C');
        $personal->setNumPersonal('10001264');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2195'));
        $this->addReference('Personal-10001264', $personal);
            $manager->persist($personal);

        // gerencia 90

        $personal = new Personal();
        $personal->setCedula('4759103');
        $personal->setNomPersonal('OBALLOS DE S , MARIELA O');
        $personal->setNumPersonal('10001731');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2196'));
        $this->addReference('Personal-10001731', $personal);
            $manager->persist($personal);


        $personal = new Personal();
        $personal->setCedula('12266006');
        $personal->setNomPersonal('TERAN R , YZAMAR C');
        $personal->setNumPersonal('10004756');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2197'));
        $this->addReference('Personal-10004756', $personal);
            $manager->persist($personal);


        $personal = new Personal();
        $personal->setCedula('9554995');
        $personal->setNomPersonal('SANTELIZ R , JHONNY');
        $personal->setNumPersonal('10017366');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2198'));
        $this->addReference('Personal-10017366', $personal);
            $manager->persist($personal);
            
        $personal = new Personal();
        $personal->setCedula('9819303');
        $personal->setNomPersonal('MENDEZ L , JONIEL J');
        $personal->setNumPersonal('10016029');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-148'));
        $this->addReference('Personal-10016029', $personal);
            $manager->persist($personal);

        $manager->flush();
    }
    
    public function getOrder(){
        return 4;
    }
    
    public function setContainer(ContainerInterface $container = null) {
        $this->container = $container;
    }
}