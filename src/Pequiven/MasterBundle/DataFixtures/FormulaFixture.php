<?php
namespace Pequiven\MasterBundle\DataFixtures;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use \Pequiven\MasterBundle\Entity\Formula;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
/**
 * Description of FormulaFixture
 *
 * @author matias
 */
class FormulaFixture extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface {
    //put your code here
    protected $container;
    public function load(ObjectManager $manager){
        
        $formula = new Formula();
        $formula->setDescription('Fórmula de Ejecución de la Producción');
        $formula->setEnabled(true);
        $formula->setEquation('(Producción Real / Producción Presupuestada) * 100');
        $this->addReference('Formula-01', $formula);
            $manager->persist($formula);
            
        $formula = new Formula();
        $formula->setDescription('Fórmula de Consumo de Materia Prima');
        $formula->setEnabled(true);
        $formula->setEquation('(Consumo Real de MP / Consumo según Presupuesto Volumétrico) * 100');
        $this->addReference('Formula-02', $formula);
            $manager->persist($formula);
            
        $formula = new Formula();
        $formula->setDescription('Fórmula de Consumo de Servicios Industriales');
        $formula->setEnabled(true);
        $formula->setEquation('(Consumo Real de Servicios / Consumo de Servicios según Presupuesto Volumétrico) * 100');
        $this->addReference('Formula-03', $formula);
            $manager->persist($formula);
            
        $formula = new Formula();
        $formula->setDescription('Fórmula de Alicuota');
        $formula->setEnabled(true);
        $formula->setEquation('(Consumo Real de Servicios Industriales o de Materia Prima / Producción Real) * 100');
        $this->addReference('Formula-05', $formula);
            $manager->persist($formula);
            
        $formula = new Formula();
        $formula->setDescription('Fórmula de Normalización de los Procesos');
        $formula->setEnabled(true);
        $formula->setEquation('(Normalización de los Procesos Real / Normalización de los Procesos Planificada)');
        $this->addReference('Formula-06', $formula);
            $manager->persist($formula);
            
        $formula = new Formula();
        $formula->setDescription('Fŕmula de Mantenimiento de los Sistemas de Gestión');
        $formula->setEnabled(true);
        $formula->setEquation('(Mantenimiento de los Sistemas de Gestión Real / Mantenimiento de los Sistemas de Gestión Planificado) * 100');
        $this->addReference('Formula-07', $formula);
            $manager->persist($formula);
            
        $formula = new Formula();
        $formula->setDescription('Fórmula de Cuentas por Cobrar');
        $formula->setEnabled(true);
        $formula->setEquation('(Monto en Bs de lo Cobrado al cierre de mes / Monto en Bs de las facturas por cobrar Vencidas (mayores a 30 días)) * 100');
        $this->addReference('Formula-08', $formula);
            $manager->persist($formula);
            
        $formula = new Formula();
        $formula->setDescription('Fórmula de Cuentas por Pagar');
        $formula->setEnabled(true);
        $formula->setEquation('(Monto en Bs de lo Pagado al cierre de mes / Monto en Bs de las facturas por pagar Vencidas (mayores a 45 días)) * 100');
        $this->addReference('Formula-09', $formula);
            $manager->persist($formula);
            
        $formula = new Formula();
        $formula->setDescription('Fórmula de Ingresos por Ventas');
        $formula->setEnabled(true);
        $formula->setEquation('(Ventas Reales / Ventas Presupuestadas) * 100');
        $this->addReference('Formula-10', $formula);
            $manager->persist($formula);
            
        $formula = new Formula();
        $formula->setDescription('Fórmula de Ejecución Presupuestaria');
        $formula->setEnabled(true);
        $formula->setEquation('(Presupuesto Ejecutado / Presupuesto Aprobado) * 100');
        $this->addReference('Formula-12', $formula);
            $manager->persist($formula);
            
        $formula = new Formula();
        $formula->setDescription('Fórmula de Costo del Producto');
        $formula->setEnabled(true);
        $formula->setEquation('(Costos variables + Costos fijos + Costos individuales + Gastos administrativos + Gastos venta + Gastos oficina principal)/TM producidas');
        $this->addReference('Formula-13', $formula);
            $manager->persist($formula);
            
        $formula = new Formula();
        $formula->setDescription('Fórmula de Egreso por compras para abastecimiento');
        $formula->setEnabled(true);
        $formula->setEquation('(Egreso por Compras Real / Egreso por Compras Presupuestado) * 100');
        $this->addReference('Formula-14', $formula);
            $manager->persist($formula);
            
        $formula = new Formula();
        $formula->setDescription('Fórmula de Rentabilidad');
        $formula->setEnabled(true);
        $formula->setEquation('(Utilidad o Pérdida Neta / Total Ingresos) * 100');
        $this->addReference('Formula-15', $formula);
            $manager->persist($formula);
            
        $formula = new Formula();
        $formula->setDescription('Fórmula de Volumétrico de Compras (Para Abastecimiento)');
        $formula->setEnabled(true);
        $formula->setEquation('(Compras Reales / Compras Presupuestadas) * 100');
        $this->addReference('Formula-16', $formula);
            $manager->persist($formula);
            
        $formula = new Formula();
        $formula->setDescription('Fórmula de Volumétrico de ventas nacionales');
        $formula->setEnabled(true);
        $formula->setEquation('(Ventas Reales / Ventas Presupuestadas) * 100');
        $this->addReference('Formula-18', $formula);
            $manager->persist($formula);
            
        $formula = new Formula();
        $formula->setDescription('Fórmula de Volumétrico de ventas internacionales (No incluye trading)');
        $formula->setEnabled(true);
        $formula->setEquation('(Ventas Internacionales Reales / Ventas Internacionales Presupuestadas) * 100');
        $this->addReference('Formula-19', $formula);
            $manager->persist($formula);
            
        $formula = new Formula();
        $formula->setDescription('Fórmula de Desarrollo de Nuevos Negocios');
        $formula->setEnabled(true);
        $formula->setEquation('Ponderación de Objetivos Tácticos y Operativos');
        $this->addReference('Formula-20', $formula);
            $manager->persist($formula);
            
        $formula = new Formula();
        $formula->setDescription('Fórmula de Avance Físico de los Proyectos de Inversión Capital');
        $formula->setEnabled(true);
        $formula->setEquation('(Avance Real / Avance Planificado) * 100');
        $this->addReference('Formula-21', $formula);
            $manager->persist($formula);
            
//        $formula = new Formula();
//        $formula->setDescription('Fórmula de Avance Financiero de los Proyectos de Inversión Capital');
//        $formula->setEnabled(true);
//        $formula->setEquation('(Avance Real / Avance Planificado) * 100');
//        $this->addReference('Formula-22', $formula);
//            $manager->persist($formula);
            
        $formula = new Formula();
        $formula->setDescription('Fórmula de Financiamiento de los Proyectos de Inversión Capital');
        $formula->setEnabled(true);
        $formula->setEquation('(Financiamiento Real / Financiamiento Planificado) * 100');
        $this->addReference('Formula-23', $formula);
            $manager->persist($formula);
            
        $formula = new Formula();
        $formula->setDescription('Fórmula de Diversificación del Negocio');
        $formula->setEnabled(true);
        $formula->setEquation('Ponderación de Objetivos Tácticos y Operativos');
        $this->addReference('Formula-24', $formula);
            $manager->persist($formula);
            
        $formula = new Formula();
        $formula->setDescription('Fórmula de Cierre de Recomendaciones de la Reaseguradora');
        $formula->setEnabled(true);
        $formula->setEquation('(Recomendaciones Cerradas / Recomendaciones Defectadas) * 100');
        $this->addReference('Formula-25', $formula);
            $manager->persist($formula);
            
        $formula = new Formula();
        $formula->setDescription('Fórmula de Accidentalidad (Frecuencia Bruta)');
        $formula->setEnabled(true);
        $formula->setEquation('(N° de Accidentes con Tiempo Perdido Acumulado y Sin Tiempo Perdido Acumulado * 1000000) / N° de Horas Trabajadas Acumuladas');
        $this->addReference('Formula-26', $formula);
            $manager->persist($formula);
            
        $formula = new Formula();
        $formula->setDescription('Fórmula de Accidentalidad (Frecuencia Neta)');
        $formula->setEnabled(true);
        $formula->setEquation('(N° de Accidentes con Tiempo Perdido Acumulado * 1000000) / N! de Horas Trabajadas Acumuladas');
        $this->addReference('Formula-27', $formula);
            $manager->persist($formula);
            
        $formula = new Formula();
        $formula->setDescription('Fórmula de Accidentalidad (Severidad)');
        $formula->setEnabled(true);
        $formula->setEquation('(N° de Días Perdidos Acumulado * 1000000) / N° de Horas Trabajadas Acumuladas');
        $this->addReference('Formula-28', $formula);
            $manager->persist($formula);
            
        $formula = new Formula();
        $formula->setDescription('Fórmula de Morbilidad (Incidencia)');
        $formula->setEnabled(true);
        $formula->setEquation('(N° de Casos Nuevos / Población en Riesgo) * 100');
        $this->addReference('Formula-29', $formula);
            $manager->persist($formula);
            
        $formula = new Formula();
        $formula->setDescription('Fórmula de Morbilidad (Prevalencia)');
        $formula->setEnabled(true);
        $formula->setEquation('(N° de Casos Incidentes Prevalentes / Población en Riesgo) * 100');
        $this->addReference('Formula-30', $formula);
            $manager->persist($formula);
            
        $formula = new Formula();
        $formula->setDescription('Fórmula de Eventos Ambientales');
        $formula->setEnabled(true);
        $formula->setEquation('Escape Sustancias Tóxicas + Escape Productos Inflamables + Emisiones con Excedencia en Normas');
        $this->addReference('Formula-31', $formula);
            $manager->persist($formula);
            
        $formula = new Formula();
        $formula->setDescription('Fórmula de Fuerza Labor');
        $formula->setEnabled(true);
        $formula->setEquation('(Labor Directa + Labor Indirecta + Beneficios + Bienestar) / Total Costo Empresa');
        $this->addReference('Formula-32', $formula);
            $manager->persist($formula);
            
        $formula = new Formula();
        $formula->setDescription('Fórmula de Eficacia de la Capacitación');
        $formula->setEnabled(true);
        $formula->setEquation('(Promedio Ponderado)Califiaciones + Medición de Competencias');
        $this->addReference('Formula-33', $formula);
            $manager->persist($formula);
            
        $formula = new Formula();
        $formula->setDescription('Fórmula de Promoción de la Cultura Organizacional');
        $formula->setEnabled(true);
        $formula->setEquation('(Promoción Real / Promoción Plan) * 100');
        $this->addReference('Formula-34', $formula);
            $manager->persist($formula);
            
        $formula = new Formula();
        $formula->setDescription('Fórmula de Índice de Desarrollo Humano');
        $formula->setEnabled(true);
        $formula->setEquation('((Valor Real - Valor Mínimo)/(Valor Real - Valor Máximo)) * 100');
        $this->addReference('Formula-35', $formula);
            $manager->persist($formula);
            
        $formula = new Formula();
        $formula->setDescription('Fórmula de Inversión en Infraestructura y Desarrollo Social');
        $formula->setEnabled(true);
        $formula->setEquation('(Presupuesto Ejecutado / Presupuesto Aprobado) * 100');
        $this->addReference('Formula-36', $formula);
            $manager->persist($formula);
            
        $formula = new Formula();
        $formula->setDescription('Por definir');
        $formula->setEnabled(true);
        $formula->setEquation('Por definir');
        $this->addReference('Formula-37', $formula);
            $manager->persist($formula);
            
        $manager->flush();
    }
    
    public function getOrder(){
        return 11;
        
    }
    
    public function setContainer(ContainerInterface $container = null) {
        $this->container = $container;
    }
}