<?php
namespace Pequiven\MasterBundle\DataFixtures\ORM;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Pequiven\MasterBundle\Entity\Formula;
use Pequiven\MasterBundle\Entity\FormulaLevel;
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
        
        $FormulaLevel = new FormulaLevel();
        $lineLevelArray = $FormulaLevel->getLevelNameArray();
        
        //NIVEL ESTRATÉGICO
        
        $formula = new Formula();
        $formula->setEnabled(true);
        $formula->setEquation('(Producción Real / Producción Presupuestada) * 100');
        $formula->setFormulaLevel($this->getReference($lineLevelArray[FormulaLevel::LEVEL_ESTRATEGICO]));
        $this->addReference('Formula-01', $formula);
            $manager->persist($formula);
            
        $formula = new Formula();        
        $formula->setEnabled(true);
        $formula->setEquation('(Consumo Real de MP / Consumo según Presupuesto Volumétrico) * 100');
        $formula->setFormulaLevel($this->getReference($lineLevelArray[FormulaLevel::LEVEL_ESTRATEGICO]));
        $this->addReference('Formula-02', $formula);
            $manager->persist($formula);
            
        $formula = new Formula();
        $formula->setEnabled(true);
        $formula->setEquation('(Consumo Real de Servicios / Consumo de Servicios según Presupuesto Volumétrico) * 100');
        $formula->setFormulaLevel($this->getReference($lineLevelArray[FormulaLevel::LEVEL_ESTRATEGICO]));
        $this->addReference('Formula-03', $formula);
            $manager->persist($formula);
            
        $formula = new Formula();        
        $formula->setEnabled(true);
        $formula->setEquation('(Consumo Real de Servicios Industriales o de Materia Prima / Producción Real) * 100');
        $formula->setFormulaLevel($this->getReference($lineLevelArray[FormulaLevel::LEVEL_ESTRATEGICO]));
        $this->addReference('Formula-05', $formula);
            $manager->persist($formula);
            
        $formula = new Formula();        
        $formula->setEnabled(true);
        $formula->setEquation('(Normalización de los Procesos Real / Normalización de los Procesos Planificada)');
        $formula->setFormulaLevel($this->getReference($lineLevelArray[FormulaLevel::LEVEL_ESTRATEGICO]));
        $this->addReference('Formula-06', $formula);
            $manager->persist($formula);
            
        $formula = new Formula();        
        $formula->setEnabled(true);
        $formula->setEquation('(Mantenimiento de los Sistemas de Gestión Real / Mantenimiento de los Sistemas de Gestión Planificado) * 100');
        $formula->setFormulaLevel($this->getReference($lineLevelArray[FormulaLevel::LEVEL_ESTRATEGICO]));
        $this->addReference('Formula-07', $formula);
            $manager->persist($formula);
            
        $formula = new Formula();
        $formula->setEnabled(true);
        $formula->setEquation('(Monto en Bs de lo Cobrado al cierre de mes / Monto en Bs de las facturas por cobrar Vencidas (mayores a 30 días)) * 100');
        $formula->setFormulaLevel($this->getReference($lineLevelArray[FormulaLevel::LEVEL_ESTRATEGICO]));
        $this->addReference('Formula-08', $formula);
            $manager->persist($formula);
            
        $formula = new Formula();
        $formula->setEnabled(true);
        $formula->setEquation('(Monto en Bs de lo Pagado al cierre de mes / Monto en Bs de las facturas por pagar Vencidas (mayores a 45 días)) * 100');
        $formula->setFormulaLevel($this->getReference($lineLevelArray[FormulaLevel::LEVEL_ESTRATEGICO]));
        $this->addReference('Formula-09', $formula);
            $manager->persist($formula);
            
        $formula = new Formula();
        $formula->setEnabled(true);
        $formula->setEquation('(Ventas Reales / Ventas Presupuestadas) * 100');
        $formula->setFormulaLevel($this->getReference($lineLevelArray[FormulaLevel::LEVEL_ESTRATEGICO]));
        $this->addReference('Formula-10', $formula);
            $manager->persist($formula);
            
        $formula = new Formula();
        $formula->setEnabled(true);
        $formula->setEquation('(Presupuesto Ejecutado / Presupuesto Aprobado) * 100');
        $formula->setFormulaLevel($this->getReference($lineLevelArray[FormulaLevel::LEVEL_ESTRATEGICO]));
        $this->addReference('Formula-12', $formula);
            $manager->persist($formula);
            
        $formula = new Formula();
        $formula->setEnabled(true);
        $formula->setEquation('(Costos variables + Costos fijos + Costos individuales + Gastos administrativos + Gastos venta + Gastos oficina principal)/TM producidas');
        $formula->setFormulaLevel($this->getReference($lineLevelArray[FormulaLevel::LEVEL_ESTRATEGICO]));
        $this->addReference('Formula-13', $formula);
            $manager->persist($formula);
            
        $formula = new Formula();
        $formula->setEnabled(true);
        $formula->setEquation('(Egreso por Compras Real / Egreso por Compras Presupuestado) * 100');
        $formula->setFormulaLevel($this->getReference($lineLevelArray[FormulaLevel::LEVEL_ESTRATEGICO]));
        $this->addReference('Formula-14', $formula);
            $manager->persist($formula);
            
        $formula = new Formula();
        $formula->setEnabled(true);
        $formula->setEquation('(Utilidad o Pérdida Neta / Total Ingresos) * 100');
        $formula->setFormulaLevel($this->getReference($lineLevelArray[FormulaLevel::LEVEL_ESTRATEGICO]));
        $this->addReference('Formula-15', $formula);
            $manager->persist($formula);
            
        $formula = new Formula();
        $formula->setEnabled(true);
        $formula->setEquation('(Compras Reales / Compras Presupuestadas) * 100');
        $formula->setFormulaLevel($this->getReference($lineLevelArray[FormulaLevel::LEVEL_ESTRATEGICO]));
        $this->addReference('Formula-16', $formula);
            $manager->persist($formula);
            
        $formula = new Formula();
        $formula->setEnabled(true);
        $formula->setEquation('(Ventas Reales / Ventas Presupuestadas) * 100');
        $formula->setFormulaLevel($this->getReference($lineLevelArray[FormulaLevel::LEVEL_ESTRATEGICO]));
        $this->addReference('Formula-18', $formula);
            $manager->persist($formula);
            
        $formula = new Formula();
        $formula->setEnabled(true);
        $formula->setEquation('(Ventas Internacionales Reales / Ventas Internacionales Presupuestadas) * 100');
        $formula->setFormulaLevel($this->getReference($lineLevelArray[FormulaLevel::LEVEL_ESTRATEGICO]));
        $this->addReference('Formula-19', $formula);
            $manager->persist($formula);
            
        $formula = new Formula();
        $formula->setEnabled(true);
        $formula->setEquation('Ponderación de Objetivos Tácticos y Operativos');
        $formula->setFormulaLevel($this->getReference($lineLevelArray[FormulaLevel::LEVEL_ESTRATEGICO]));
        $this->addReference('Formula-20', $formula);
            $manager->persist($formula);
            
        $formula = new Formula();
        $formula->setEnabled(true);
        $formula->setEquation('(Avance Real / Avance Planificado) * 100');
        $formula->setFormulaLevel($this->getReference($lineLevelArray[FormulaLevel::LEVEL_ESTRATEGICO]));
        $this->addReference('Formula-21', $formula);
            $manager->persist($formula);
            
//        $formula = new Formula();
//        $formula->setDescription('Fórmula de Avance Financiero de los Proyectos de Inversión Capital');
//        $formula->setEnabled(true);
//        $formula->setEquation('(Avance Real / Avance Planificado) * 100');
//        $this->addReference('Formula-22', $formula);
//            $manager->persist($formula);
            
        $formula = new Formula();
        $formula->setEnabled(true);
        $formula->setEquation('(Financiamiento Real / Financiamiento Planificado) * 100');
        $formula->setFormulaLevel($this->getReference($lineLevelArray[FormulaLevel::LEVEL_ESTRATEGICO]));
        $this->addReference('Formula-23', $formula);
            $manager->persist($formula);
            
//        $formula = new Formula();
//        $formula->setDescription('Fórmula de Diversificación del Negocio');
//        $formula->setEnabled(true);
//        $formula->setEquation('Ponderación de Objetivos Tácticos y Operativos');
//        $formula->setFormulaLevel($this->getReference($lineLevelArray[FormulaLevel::LEVEL_ESTRATEGICO]));
//        $this->addReference('Formula-24', $formula);
//            $manager->persist($formula);
            
        $formula = new Formula();
        $formula->setEnabled(true);
        $formula->setEquation('(Recomendaciones Cerradas / Recomendaciones Defectadas) * 100');
        $formula->setFormulaLevel($this->getReference($lineLevelArray[FormulaLevel::LEVEL_ESTRATEGICO]));
        $this->addReference('Formula-25', $formula);
            $manager->persist($formula);
            
        $formula = new Formula();
        $formula->setEnabled(true);
        $formula->setEquation('(N° de Accidentes con Tiempo Perdido Acumulado y Sin Tiempo Perdido Acumulado * 1000000) / N° de Horas Trabajadas Acumuladas');
        $formula->setFormulaLevel($this->getReference($lineLevelArray[FormulaLevel::LEVEL_ESTRATEGICO]));
        $this->addReference('Formula-26', $formula);
            $manager->persist($formula);
            
        $formula = new Formula();
        $formula->setEnabled(true);
        $formula->setEquation('(N° de Accidentes con Tiempo Perdido Acumulado * 1000000) / N! de Horas Trabajadas Acumuladas');
        $formula->setFormulaLevel($this->getReference($lineLevelArray[FormulaLevel::LEVEL_ESTRATEGICO]));
        $this->addReference('Formula-27', $formula);
            $manager->persist($formula);
            
        $formula = new Formula();
        $formula->setEnabled(true);
        $formula->setEquation('(N° de Días Perdidos Acumulado * 1000000) / N° de Horas Trabajadas Acumuladas');
        $formula->setFormulaLevel($this->getReference($lineLevelArray[FormulaLevel::LEVEL_ESTRATEGICO]));
        $this->addReference('Formula-28', $formula);
            $manager->persist($formula);
            
        $formula = new Formula();
        $formula->setEnabled(true);
        $formula->setEquation('(N° de Casos Nuevos / Población en Riesgo) * 100');
        $formula->setFormulaLevel($this->getReference($lineLevelArray[FormulaLevel::LEVEL_ESTRATEGICO]));
        $this->addReference('Formula-29', $formula);
            $manager->persist($formula);
            
        $formula = new Formula();
        $formula->setEnabled(true);
        $formula->setEquation('(N° de Casos Incidentes Prevalentes / Población en Riesgo) * 100');
        $formula->setFormulaLevel($this->getReference($lineLevelArray[FormulaLevel::LEVEL_ESTRATEGICO]));
        $this->addReference('Formula-30', $formula);
            $manager->persist($formula);
            
        $formula = new Formula();
        $formula->setEnabled(true);
        $formula->setEquation('Escape Sustancias Tóxicas + Escape Productos Inflamables + Emisiones con Excedencia en Normas');
        $formula->setFormulaLevel($this->getReference($lineLevelArray[FormulaLevel::LEVEL_ESTRATEGICO]));
        $this->addReference('Formula-31', $formula);
            $manager->persist($formula);
            
        $formula = new Formula();
        $formula->setEnabled(true);
        $formula->setEquation('(Labor Directa + Labor Indirecta + Beneficios + Bienestar) / Total Costo Empresa');
        $formula->setFormulaLevel($this->getReference($lineLevelArray[FormulaLevel::LEVEL_ESTRATEGICO]));
        $this->addReference('Formula-32', $formula);
            $manager->persist($formula);
            
        $formula = new Formula();
        $formula->setEnabled(true);
        $formula->setEquation('(Promedio Ponderado)Califiaciones + Medición de Competencias');
        $formula->setFormulaLevel($this->getReference($lineLevelArray[FormulaLevel::LEVEL_ESTRATEGICO]));
        $this->addReference('Formula-33', $formula);
            $manager->persist($formula);
            
        $formula = new Formula();
        $formula->setEnabled(true);
        $formula->setEquation('(Promoción Real / Promoción Plan) * 100');
        $formula->setFormulaLevel($this->getReference($lineLevelArray[FormulaLevel::LEVEL_ESTRATEGICO]));
        $this->addReference('Formula-34', $formula);
            $manager->persist($formula);
            
        $formula = new Formula();
        $formula->setEnabled(true);
        $formula->setEquation('((Valor Real - Valor Mínimo)/(Valor Real - Valor Máximo)) * 100');
        $formula->setFormulaLevel($this->getReference($lineLevelArray[FormulaLevel::LEVEL_ESTRATEGICO]));
        $this->addReference('Formula-35', $formula);
            $manager->persist($formula);
            
        $formula = new Formula();
        $formula->setEnabled(true);
        $formula->setEquation('(Presupuesto Ejecutado / Presupuesto Aprobado) * 100');
        $formula->setFormulaLevel($this->getReference($lineLevelArray[FormulaLevel::LEVEL_ESTRATEGICO]));
        $this->addReference('Formula-36', $formula);
            $manager->persist($formula);
            
        //NIVEL TÁCTICO
        $formula = new Formula();
        $formula->setEnabled(true);
        $formula->setEquation('(Σdisponibilidad de los servicios de AIT / Número de servicios de AIT) * 100');
        $formula->setFormulaLevel($this->getReference($lineLevelArray[FormulaLevel::LEVEL_TACTICO]));
        $this->addReference('Formula-37', $formula);
            $manager->persist($formula);
            
        $formula = new Formula();
        $formula->setEnabled(true);
        $formula->setEquation('(Total encuestas excelente+total encuestas buena / Total encuestas) * 100');
        $formula->setFormulaLevel($this->getReference($lineLevelArray[FormulaLevel::LEVEL_TACTICO]));
        $this->addReference('Formula-38', $formula);
            $manager->persist($formula);
            
        $formula = new Formula();
        $formula->setEnabled(true);
        $formula->setEquation('(Σ%avance proyectos de AIT / Número de proyectos de AIT) * 100');
        $formula->setFormulaLevel($this->getReference($lineLevelArray[FormulaLevel::LEVEL_TACTICO]));
        $this->addReference('Formula-39', $formula);
            $manager->persist($formula);
        
        $formula = new Formula();
        $formula->setEnabled(true);
        $formula->setEquation('(Actuaciones ejecutadas / Actuaciones planificadas) * 100');
        $formula->setFormulaLevel($this->getReference($lineLevelArray[FormulaLevel::LEVEL_TACTICO]));
        $this->addReference('Formula-40', $formula);
            $manager->persist($formula);
        
        $formula = new Formula();
        $formula->setEnabled(true);
        $formula->setEquation('(N° de actividades realizadas / N° de actividades determinadas) * 100');
        $formula->setFormulaLevel($this->getReference($lineLevelArray[FormulaLevel::LEVEL_TACTICO]));
        $this->addReference('Formula-41', $formula);
            $manager->persist($formula);
        
        $formula = new Formula();
        $formula->setEnabled(true);
        $formula->setEquation('%PGAC= (Actividades Realizadas/Actividades Planificadas)*100 ');
        $formula->setFormulaLevel($this->getReference($lineLevelArray[FormulaLevel::LEVEL_TACTICO]));
        $this->addReference('Formula-42', $formula);
            $manager->persist($formula);
        
        $formula = new Formula();
        $formula->setEnabled(true);
        $formula->setEquation('%TPQC= (TM movilizadas/ TM planificadas) *100 ');
        $formula->setFormulaLevel($this->getReference($lineLevelArray[FormulaLevel::LEVEL_TACTICO]));
        $this->addReference('Formula-43', $formula);
            $manager->persist($formula);
        
        $formula = new Formula();
        $formula->setEnabled(true);
        $formula->setEquation('Convenio y Alianzas Consolidados / Convenios y Alianzas necesarios * 100% ');
        $formula->setFormulaLevel($this->getReference($lineLevelArray[FormulaLevel::LEVEL_TACTICO]));
        $this->addReference('Formula-44', $formula);
            $manager->persist($formula);
        
        $formula = new Formula();
        $formula->setEnabled(true);
        $formula->setEquation('Asesoramiento solicitado / Asesoramiento Atendido * 100% ');
        $formula->setFormulaLevel($this->getReference($lineLevelArray[FormulaLevel::LEVEL_TACTICO]));
        $this->addReference('Formula-45', $formula);
            $manager->persist($formula);
        
        $formula = new Formula();
        $formula->setEnabled(true);
        $formula->setEquation('Representaciones Ejecutadas / Requerimientos de representación * 100% ');
        $formula->setFormulaLevel($this->getReference($lineLevelArray[FormulaLevel::LEVEL_TACTICO]));
        $this->addReference('Formula-46', $formula);
            $manager->persist($formula);
        
        $formula = new Formula();
        $formula->setEnabled(true);
        $formula->setEquation('SPCALCP = (Número de procedimientos CA-CC-CP finalizados / Número de procedimientos CA-CC-CP solicitados) * 100 ');
        $formula->setFormulaLevel($this->getReference($lineLevelArray[FormulaLevel::LEVEL_TACTICO]));
        $this->addReference('Formula-47', $formula);
            $manager->persist($formula);
        
        $formula = new Formula();
        $formula->setEnabled(true);
        $formula->setEquation('SPCANI = (Número de procedimientos CD-AD finalizados / Número de procedimientos CD-AD solicitados) * 100 ');
        $formula->setFormulaLevel($this->getReference($lineLevelArray[FormulaLevel::LEVEL_TACTICO]));
        $this->addReference('Formula-48', $formula);
            $manager->persist($formula);
        
//        $formula = new Formula();
//        $formula->setEnabled(true);
//        $formula->setEquation('SPCALCP = (Número de procedimientos CA-CC-CP finalizados / Número de procedimientos CA-CC-CP solicitados) * 100');
//        $formula->setFormulaLevel($this->getReference($lineLevelArray[FormulaLevel::LEVEL_TACTICO]));
//        $this->addReference('Formula-49', $formula);
//            $manager->persist($formula);
//        
//        $formula = new Formula();
//        $formula->setEnabled(true);
//        $formula->setEquation('SPCANI = (Número de procedimientos CD-AD finalizados / Número de procedimientos CD-AD solicitados) * 100 ');
//        $formula->setFormulaLevel($this->getReference($lineLevelArray[FormulaLevel::LEVEL_TACTICO]));
//        $this->addReference('Formula-50', $formula);
//            $manager->persist($formula);
        
        $formula = new Formula();
        $formula->setEnabled(true);
        $formula->setEquation('Confiabilidad = [1-(ΣProductos con desviación / ΣProductos)] * 100% ');
        $formula->setFormulaLevel($this->getReference($lineLevelArray[FormulaLevel::LEVEL_TACTICO]));
        $this->addReference('Formula-51', $formula);
            $manager->persist($formula);
        
        $formula = new Formula();
        $formula->setEnabled(true);
        $formula->setEquation('Consignación Oportuna = (ΣProductos entregados oportunamente / ΣSolicitudes)');
        $formula->setFormulaLevel($this->getReference($lineLevelArray[FormulaLevel::LEVEL_TACTICO]));
        $this->addReference('Formula-52', $formula);
            $manager->persist($formula);
        
        $formula = new Formula();
        $formula->setEnabled(true);
        $formula->setEquation('Resolución de conformación de Comité de Finanzas');
        $formula->setFormulaLevel($this->getReference($lineLevelArray[FormulaLevel::LEVEL_TACTICO]));
        $this->addReference('Formula-53', $formula);
            $manager->persist($formula);
            
        $formula = new Formula();
        $formula->setEnabled(true);
        $formula->setEquation('Informe de Conceptualizacion  de mecanismo de Control de Costos');
        $formula->setFormulaLevel($this->getReference($lineLevelArray[FormulaLevel::LEVEL_TACTICO]));
        $this->addReference('Formula-54', $formula);
            $manager->persist($formula);
            
        $formula = new Formula();
        $formula->setEnabled(true);
        $formula->setEquation('(Productos de Información consignados en tiempo oportuno / Productos de Información consignados) * 100');
        $formula->setFormulaLevel($this->getReference($lineLevelArray[FormulaLevel::LEVEL_TACTICO]));
        $this->addReference('Formula-55', $formula);
            $manager->persist($formula);
            
        $formula = new Formula();
        $formula->setEnabled(true);
        $formula->setEquation('CPGO = (ΣAPGOE / ΣAPGOP) * 100');
        $formula->setFormulaLevel($this->getReference($lineLevelArray[FormulaLevel::LEVEL_TACTICO]));
        $this->addReference('Formula-56', $formula);
            $manager->persist($formula);
            
        $formula = new Formula();
        $formula->setEnabled(true);
        $formula->setEquation('CPPPAI = (ΣAPAIE / ΣAPAIP) * 100');
        $formula->setFormulaLevel($this->getReference($lineLevelArray[FormulaLevel::LEVEL_TACTICO]));
        $this->addReference('Formula-57', $formula);
            $manager->persist($formula);
            
        $formula = new Formula();
        $formula->setEnabled(true);
        $formula->setEquation('EIIG = (ΣIIO / ΣIIG) * 100');
        $formula->setFormulaLevel($this->getReference($lineLevelArray[FormulaLevel::LEVEL_TACTICO]));
        $this->addReference('Formula-58', $formula);
            $manager->persist($formula);
            
        $formula = new Formula();
        $formula->setEnabled(true);
        $formula->setEquation('CPACG = (ΣAPACGE / ΣAPACGP) * 100');
        $formula->setFormulaLevel($this->getReference($lineLevelArray[FormulaLevel::LEVEL_TACTICO]));
        $this->addReference('Formula-59', $formula);
            $manager->persist($formula);
            
        $formula = new Formula();
        $formula->setEnabled(true);
        $formula->setEquation('SEIP = Real/Plan * 100');
        $formula->setFormulaLevel($this->getReference($lineLevelArray[FormulaLevel::LEVEL_TACTICO]));
        $this->addReference('Formula-60', $formula);
            $manager->persist($formula);
            
        $formula = new Formula();
        $formula->setEnabled(true);
        $formula->setEquation('SGD = Real/Plan * 100');
        $formula->setFormulaLevel($this->getReference($lineLevelArray[FormulaLevel::LEVEL_TACTICO]));
        $this->addReference('Formula-61', $formula);
            $manager->persist($formula);
            
        $formula = new Formula();
        $formula->setEnabled(true);
        $formula->setEquation('Plan Estratégico Diseñado');
        $formula->setFormulaLevel($this->getReference($lineLevelArray[FormulaLevel::LEVEL_TACTICO]));
        $this->addReference('Formula-62', $formula);
            $manager->persist($formula);
            
        $formula = new Formula();
        $formula->setEnabled(true);
        $formula->setEquation('(Procesos adaptados al modelo de competencias / procesos planificados) * 100 ');
        $formula->setFormulaLevel($this->getReference($lineLevelArray[FormulaLevel::LEVEL_TACTICO]));
        $this->addReference('Formula-63', $formula);
            $manager->persist($formula);
            
        $formula = new Formula();
        $formula->setEnabled(true);
        $formula->setEquation('(Avance programa supervisorio ejecutado / programa supervisorio planificado) * 100 ');
        $formula->setFormulaLevel($this->getReference($lineLevelArray[FormulaLevel::LEVEL_TACTICO]));
        $this->addReference('Formula-64', $formula);
            $manager->persist($formula);
            
        $formula = new Formula();
        $formula->setEnabled(true);
        $formula->setEquation('((Costo Labor Ejecutado/N° de Fuerza Labor Activa)/(Costo Labor Planificado/Fuerza labor Planificada))*100 ');
        $formula->setFormulaLevel($this->getReference($lineLevelArray[FormulaLevel::LEVEL_TACTICO]));
        $this->addReference('Formula-65', $formula);
            $manager->persist($formula);
            
        $formula = new Formula();
        $formula->setEnabled(true);
        $formula->setEquation('(((Presupuesto Ejecutado/Presupuesto Planificado)+(Actividades Ejecutadas/Actividades Planificadas))/2)*100 ');
        $formula->setFormulaLevel($this->getReference($lineLevelArray[FormulaLevel::LEVEL_TACTICO]));
        $this->addReference('Formula-66', $formula);
            $manager->persist($formula);
            
        $formula = new Formula();
        $formula->setEnabled(true);
        $formula->setEquation('(N° de Quejas y Reclamos / N° de Trabajadores) * 100 ');
        $formula->setFormulaLevel($this->getReference($lineLevelArray[FormulaLevel::LEVEL_TACTICO]));
        $this->addReference('Formula-67', $formula);
            $manager->persist($formula);
            
        $formula = new Formula();
        $formula->setEnabled(true);
        $formula->setEquation('(% de Procesamiento solicitudes de Reembolsos+% de Procesamiento de Cartas Avales Iniciales+ % de procesamiento de Facturas ');
        $formula->setFormulaLevel($this->getReference($lineLevelArray[FormulaLevel::LEVEL_TACTICO]));
        $this->addReference('Formula-68', $formula);
            $manager->persist($formula);
            
        $formula = new Formula();
        $formula->setEnabled(true);
        $formula->setEquation('(Actividades planificadas/Actividades Ejecutadas)*100 ');
        $formula->setFormulaLevel($this->getReference($lineLevelArray[FormulaLevel::LEVEL_TACTICO]));
        $this->addReference('Formula-69', $formula);
            $manager->persist($formula);
            
        //NIVEL OPERATIVO
            
        $formula = new Formula();
        $formula->setEnabled(true);
        $formula->setEquation('(Real/Plan) * 100%');
        $formula->setFormulaLevel($this->getReference($lineLevelArray[FormulaLevel::LEVEL_OPERATIVO]));
        $this->addReference('Formula-70', $formula);
            $manager->persist($formula);
            
        $formula = new Formula();
        $formula->setEnabled(true);
        $formula->setEquation('%PA = PA / TP');
        $formula->setFormulaLevel($this->getReference($lineLevelArray[FormulaLevel::LEVEL_OPERATIVO]));
        $this->addReference('Formula-71', $formula);
            $manager->persist($formula);
            
        $formula = new Formula();
        $formula->setEnabled(true);
        $formula->setEquation('%PE = PE/TRP');
        $formula->setFormulaLevel($this->getReference($lineLevelArray[FormulaLevel::LEVEL_OPERATIVO]));
        $this->addReference('Formula-72', $formula);
            $manager->persist($formula);
            
        $formula = new Formula();
        $formula->setEnabled(true);
        $formula->setEquation('%AT = AR / TA');
        $formula->setFormulaLevel($this->getReference($lineLevelArray[FormulaLevel::LEVEL_OPERATIVO]));
        $this->addReference('Formula-73', $formula);
            $manager->persist($formula);
            
        $formula = new Formula();
        $formula->setEnabled(true);
        $formula->setEquation('%SA = SA / TS');
        $formula->setFormulaLevel($this->getReference($lineLevelArray[FormulaLevel::LEVEL_OPERATIVO]));
        $this->addReference('Formula-74', $formula);
            $manager->persist($formula);
            
        $formula = new Formula();
        $formula->setEnabled(true);
        $formula->setEquation('%RE = RE/TRP');
        $formula->setFormulaLevel($this->getReference($lineLevelArray[FormulaLevel::LEVEL_OPERATIVO]));
        $this->addReference('Formula-75', $formula);
            $manager->persist($formula);
            
        $formula = new Formula();
        $formula->setEnabled(true);
        $formula->setEquation('%CE = CT/TCT');
        $formula->setFormulaLevel($this->getReference($lineLevelArray[FormulaLevel::LEVEL_OPERATIVO]));
        $this->addReference('Formula-76', $formula);
            $manager->persist($formula);
            
        $formula = new Formula();
        $formula->setEnabled(true);
        $formula->setEquation('%AE = AE/AP');
        $formula->setFormulaLevel($this->getReference($lineLevelArray[FormulaLevel::LEVEL_OPERATIVO]));
        $this->addReference('Formula-77', $formula);
            $manager->persist($formula);
            
        $formula = new Formula();
        $formula->setEnabled(true);
        $formula->setEquation('%ET = ET/TER');
        $formula->setFormulaLevel($this->getReference($lineLevelArray[FormulaLevel::LEVEL_OPERATIVO]));
        $this->addReference('Formula-78', $formula);
            $manager->persist($formula);
            
        $formula = new Formula();
        $formula->setEnabled(true);
        $formula->setEquation('%CR = CR/TCR');
        $formula->setFormulaLevel($this->getReference($lineLevelArray[FormulaLevel::LEVEL_OPERATIVO]));
        $this->addReference('Formula-79', $formula);
            $manager->persist($formula);
            
        $formula = new Formula();
        $formula->setEnabled(true);
        $formula->setEquation('%RC = RC/TRC');
        $formula->setFormulaLevel($this->getReference($lineLevelArray[FormulaLevel::LEVEL_OPERATIVO]));
        $this->addReference('Formula-80', $formula);
            $manager->persist($formula);
            
        $formula = new Formula();
        $formula->setEnabled(true);
        $formula->setEquation('%RE = RE/TRE');
        $formula->setFormulaLevel($this->getReference($lineLevelArray[FormulaLevel::LEVEL_OPERATIVO]));
        $this->addReference('Formula-81', $formula);
            $manager->persist($formula);
            
        $formula = new Formula();
        $formula->setEnabled(true);
        $formula->setEquation('%AM = AR/TAP');
        $formula->setFormulaLevel($this->getReference($lineLevelArray[FormulaLevel::LEVEL_OPERATIVO]));
        $this->addReference('Formula-82', $formula);
            $manager->persist($formula);
            
        $formula = new Formula();
        $formula->setEnabled(true);
        $formula->setEquation('(Solicicitudes atendidas / Solicitudes recibidas) * 100');
        $formula->setFormulaLevel($this->getReference($lineLevelArray[FormulaLevel::LEVEL_OPERATIVO]));
        $this->addReference('Formula-83', $formula);
            $manager->persist($formula);
            
        $formula = new Formula();
        $formula->setEnabled(true);
        $formula->setEquation(' Σ disponibilidad de los servicios de Telecomunicaciones / numero de servicios de Telecomunicaciones');
        $formula->setFormulaLevel($this->getReference($lineLevelArray[FormulaLevel::LEVEL_OPERATIVO]));
        $this->addReference('Formula-84', $formula);
            $manager->persist($formula);
            
        $formula = new Formula();
        $formula->setEnabled(true);
        $formula->setEquation('Σ disponibilidad de los servicios de plataforma  y  tecnología de la información / numero de servicios de plataforma y tecnología de la información');
        $formula->setFormulaLevel($this->getReference($lineLevelArray[FormulaLevel::LEVEL_OPERATIVO]));
        $this->addReference('Formula-85', $formula);
            $manager->persist($formula);
            
        $formula = new Formula();
        $formula->setEnabled(true);
        $formula->setEquation('(% de requerimientos atendidos / % requerimientos recibidos) * 100');
        $formula->setFormulaLevel($this->getReference($lineLevelArray[FormulaLevel::LEVEL_OPERATIVO]));
        $this->addReference('Formula-86', $formula);
            $manager->persist($formula);
            
        $formula = new Formula();
        $formula->setEnabled(true);
        $formula->setEquation('(Total encuestas excelente+total encuesta buena/Total encuesta)*100');
        $formula->setFormulaLevel($this->getReference($lineLevelArray[FormulaLevel::LEVEL_OPERATIVO]));
        $this->addReference('Formula-87', $formula);
            $manager->persist($formula);
            
        $formula = new Formula();
        $formula->setEnabled(true);
        $formula->setEquation('Total de casos cerrados en segundo nivel*100/ Total de casos escalados al área');
        $formula->setFormulaLevel($this->getReference($lineLevelArray[FormulaLevel::LEVEL_OPERATIVO]));
        $this->addReference('Formula-88', $formula);
            $manager->persist($formula);
            
        $formula = new Formula();
        $formula->setEnabled(true);
        $formula->setEquation('(Total encuestas excelente+total encuesta buena/Total encuesta)*100');
        $formula->setFormulaLevel($this->getReference($lineLevelArray[FormulaLevel::LEVEL_OPERATIVO]));
        $this->addReference('Formula-89', $formula);
            $manager->persist($formula);
            
        $formula = new Formula();
        $formula->setEnabled(true);
        $formula->setEquation('(% de cumplimiento alcanzado / % cumplimiento establecido) * 100');
        $formula->setFormulaLevel($this->getReference($lineLevelArray[FormulaLevel::LEVEL_OPERATIVO]));
        $this->addReference('Formula-90', $formula);
            $manager->persist($formula);
            
        $formula = new Formula();
        $formula->setEnabled(true);
        $formula->setEquation('Total inventario lógico operativo y stock Occidente/ Total inventario físico operativo y stock Occidente * 100');
        $formula->setFormulaLevel($this->getReference($lineLevelArray[FormulaLevel::LEVEL_OPERATIVO]));
        $this->addReference('Formula-91', $formula);
            $manager->persist($formula);
            
        $formula = new Formula();
        $formula->setEnabled(true);
        $formula->setEquation('Total inventario lógico operativo y stock Oriente/ Total inventario físico operativo y stock Oriente * 100');
        $formula->setFormulaLevel($this->getReference($lineLevelArray[FormulaLevel::LEVEL_OPERATIVO]));
        $this->addReference('Formula-92', $formula);
            $manager->persist($formula);
            
        $formula = new Formula();
        $formula->setEnabled(true);
        $formula->setEquation('Total inventario lógico operativo y stock Centro/ Total inventario físico operativo y stock Centro * 100');
        $formula->setFormulaLevel($this->getReference($lineLevelArray[FormulaLevel::LEVEL_OPERATIVO]));
        $this->addReference('Formula-93', $formula);
            $manager->persist($formula);
            
        $formula = new Formula();
        $formula->setEnabled(true);
        $formula->setEquation(' Σ % avance proyectos de Telecomunicaciones / Número de proyectos de Telecomunicaciones');
        $formula->setFormulaLevel($this->getReference($lineLevelArray[FormulaLevel::LEVEL_OPERATIVO]));
        $this->addReference('Formula-94', $formula);
            $manager->persist($formula);
            
        $formula = new Formula();
        $formula->setEnabled(true);
        $formula->setEquation(' Σ % avance proyectos de de ampliación y actualización de la infraestructura de tecnología de la información  / Número de proyectos de de ampliación y actualización de la infraestructura de tecnología de la información ');
        $formula->setFormulaLevel($this->getReference($lineLevelArray[FormulaLevel::LEVEL_OPERATIVO]));
        $this->addReference('Formula-95', $formula);
            $manager->persist($formula);
            
        $formula = new Formula();
        $formula->setEnabled(true);
        $formula->setEquation(' Σ % avance proyectos de Sistemas y Aplicaciones/ Número de proyectos de Sistemas y Aplicaciones');
        $formula->setFormulaLevel($this->getReference($lineLevelArray[FormulaLevel::LEVEL_OPERATIVO]));
        $this->addReference('Formula-96', $formula);
            $manager->persist($formula);
            
        $formula = new Formula();
        $formula->setEnabled(true);
        $formula->setEquation('Procesadas/Recibidas');
        $formula->setFormulaLevel($this->getReference($lineLevelArray[FormulaLevel::LEVEL_OPERATIVO]));
        $this->addReference('Formula-97', $formula);
            $manager->persist($formula);
            
        $formula = new Formula();
        $formula->setEnabled(true);
        $formula->setEquation('(Actuaciones ejecutadas / Actuaciones planificadas) * 100');
        $formula->setFormulaLevel($this->getReference($lineLevelArray[FormulaLevel::LEVEL_OPERATIVO]));
        $this->addReference('Formula-98', $formula);
            $manager->persist($formula);
            
        $formula = new Formula();
        $formula->setEnabled(true);
        $formula->setEquation('Procedimientos iniciados / Autos de proceder');
        $formula->setFormulaLevel($this->getReference($lineLevelArray[FormulaLevel::LEVEL_OPERATIVO]));
        $this->addReference('Formula-99', $formula);
            $manager->persist($formula);
            
        $formula = new Formula();
        $formula->setEnabled(true);
        $formula->setEquation('Seguimiento Ejecutado / Seguimiento planificado');
        $formula->setFormulaLevel($this->getReference($lineLevelArray[FormulaLevel::LEVEL_OPERATIVO]));
        $this->addReference('Formula-100', $formula);
            $manager->persist($formula);
            
        $formula = new Formula();
        $formula->setEnabled(true);
        $formula->setEquation('Procedimientos iniciados / procedimientos solicitados');
        $formula->setFormulaLevel($this->getReference($lineLevelArray[FormulaLevel::LEVEL_OPERATIVO]));
        $this->addReference('Formula-101', $formula);
            $manager->persist($formula);
            
        $formula = new Formula();
        $formula->setEnabled(true);
        $formula->setEquation('N° de actividades realizadas');
        $formula->setFormulaLevel($this->getReference($lineLevelArray[FormulaLevel::LEVEL_OPERATIVO]));
        $this->addReference('Formula-102', $formula);
            $manager->persist($formula);
            
        $formula = new Formula();
        $formula->setEnabled(true);
        $formula->setEquation('(Compras Int. Reales Fertilizantes / Compras Int. Solicitadas) x 100%');
        $formula->setFormulaLevel($this->getReference($lineLevelArray[FormulaLevel::LEVEL_OPERATIVO]));
        $this->addReference('Formula-103', $formula);
            $manager->persist($formula);
            
        $formula = new Formula();
        $formula->setEnabled(true);
        $formula->setEquation('Compras Int. Reales Productos Químicos / Compras Int. Solicitadas x 100%');
        $formula->setFormulaLevel($this->getReference($lineLevelArray[FormulaLevel::LEVEL_OPERATIVO]));
        $this->addReference('Formula-104', $formula);
            $manager->persist($formula);
            
        $formula = new Formula();
        $formula->setEnabled(true);
        $formula->setEquation('(Compras Reales Resinas Plásticas / Compras Int. Solicitadas) x 100%');
        $formula->setFormulaLevel($this->getReference($lineLevelArray[FormulaLevel::LEVEL_OPERATIVO]));
        $this->addReference('Formula-105', $formula);
            $manager->persist($formula);
            
        $formula = new Formula();
        $formula->setEnabled(true);
        $formula->setEquation('% Cumplimiento de Ventas = (Ventas Reales/Ventas Programadas) * 100%');
        $formula->setFormulaLevel($this->getReference($lineLevelArray[FormulaLevel::LEVEL_OPERATIVO]));
        $this->addReference('Formula-106', $formula);
            $manager->persist($formula);
            
        $formula = new Formula();
        $formula->setEnabled(true);
        $formula->setEquation('% Cumplimiento de Análisis de Entorno = (Actividades Ejecutadas/Actividades Planificadas) * 100%');
        $formula->setFormulaLevel($this->getReference($lineLevelArray[FormulaLevel::LEVEL_OPERATIVO]));
        $this->addReference('Formula-107', $formula);
            $manager->persist($formula);
            
        $formula = new Formula();
        $formula->setEnabled(true);
        $formula->setEquation('% Clientes Satisfechos = ΣClientes>=4,00/ΣClientes');
        $formula->setFormulaLevel($this->getReference($lineLevelArray[FormulaLevel::LEVEL_OPERATIVO]));
        $this->addReference('Formula-108', $formula);
            $manager->persist($formula);
            
        $formula = new Formula();
        $formula->setEnabled(true);
        $formula->setEquation('% CPV = (Ventas Realizadas/Ventas Planificadas )*100');
        $formula->setFormulaLevel($this->getReference($lineLevelArray[FormulaLevel::LEVEL_OPERATIVO]));
        $this->addReference('Formula-109', $formula);
            $manager->persist($formula);
            
        $formula = new Formula();
        $formula->setEnabled(true);
        $formula->setEquation('% CPIM = (Actividades Realizada PIM/ Actividades Planificadas PIM)*100');
        $formula->setFormulaLevel($this->getReference($lineLevelArray[FormulaLevel::LEVEL_OPERATIVO]));
        $this->addReference('Formula-110', $formula);
            $manager->persist($formula);
            
        $formula = new Formula();
        $formula->setEnabled(true);
        $formula->setEquation('CPSACMS = (Actividades Realizada PSAC/ Actividades Planificadas PSAC)*100');
        $formula->setFormulaLevel($this->getReference($lineLevelArray[FormulaLevel::LEVEL_OPERATIVO]));
        $this->addReference('Formula-111', $formula);
            $manager->persist($formula);
            
        $formula = new Formula();
        $formula->setEnabled(true);
        $formula->setEquation('% CPDP = (Actividades Realizada PDP/ Actividades Planificadas PIM)*100');
        $formula->setFormulaLevel($this->getReference($lineLevelArray[FormulaLevel::LEVEL_OPERATIVO]));
        $this->addReference('Formula-112', $formula);
            $manager->persist($formula);
            
        $formula = new Formula();
        $formula->setEnabled(true);
        $formula->setEquation('% CPPPDC = (Actividades Realizada PDC / Actividades PlanificadasPDC)*100');
        $formula->setFormulaLevel($this->getReference($lineLevelArray[FormulaLevel::LEVEL_OPERATIVO]));
        $this->addReference('Formula-113', $formula);
            $manager->persist($formula);
            
        $formula = new Formula();
        $formula->setEnabled(true);
        $formula->setEquation(' % Cumplimiento Ejec y Seg Plan Compras Int = Compras Reales ejecutadas / Plan Promediado * 100');
        $formula->setFormulaLevel($this->getReference($lineLevelArray[FormulaLevel::LEVEL_OPERATIVO]));
        $this->addReference('Formula-114', $formula);
            $manager->persist($formula);
            
        $formula = new Formula();
        $formula->setEnabled(true);
        $formula->setEquation('Ventas Reales Ejecutadas / Ventas Planificadas * 100');
        $formula->setFormulaLevel($this->getReference($lineLevelArray[FormulaLevel::LEVEL_OPERATIVO]));
        $this->addReference('Formula-115', $formula);
            $manager->persist($formula);
            
        $formula = new Formula();
        $formula->setEnabled(true);
        $formula->setEquation('Avance Real de los proyectos/ Avance Planificados de los proyectos * 100');
        $formula->setFormulaLevel($this->getReference($lineLevelArray[FormulaLevel::LEVEL_OPERATIVO]));
        $this->addReference('Formula-116', $formula);
            $manager->persist($formula);
            
        $formula = new Formula();
        $formula->setEnabled(true);
        $formula->setEquation('Resultado Encuesta de Medición de Satisfacción');
        $formula->setFormulaLevel($this->getReference($lineLevelArray[FormulaLevel::LEVEL_OPERATIVO]));
        $this->addReference('Formula-117', $formula);
            $manager->persist($formula);
            
        $formula = new Formula();
        $formula->setEnabled(true);
        $formula->setEquation('N° de Quejas y reclamos atendidos antes de los 45 días/Total de Quejas y reclamos al mes*100');
        $formula->setFormulaLevel($this->getReference($lineLevelArray[FormulaLevel::LEVEL_OPERATIVO]));
        $this->addReference('Formula-118', $formula);
            $manager->persist($formula);
            
        $formula = new Formula();
        $formula->setEnabled(true);
        $formula->setEquation('%PGAC= (Actividades Realizadas/Actividades Planificadas)*100');
        $formula->setFormulaLevel($this->getReference($lineLevelArray[FormulaLevel::LEVEL_OPERATIVO]));
        $this->addReference('Formula-119', $formula);
            $manager->persist($formula);
            
        $formula = new Formula();
        $formula->setEnabled(true);
        $formula->setEquation('%TF= (TM movilizadas/ TM planificadas) *100 (Ensacado)');
        $formula->setFormulaLevel($this->getReference($lineLevelArray[FormulaLevel::LEVEL_OPERATIVO]));
        $this->addReference('Formula-120', $formula);
            $manager->persist($formula);
            
        $formula = new Formula();
        $formula->setEnabled(true);
        $formula->setEquation('%TPI= (TM movilizadas/ TM planificadas) *100 ');
        $formula->setFormulaLevel($this->getReference($lineLevelArray[FormulaLevel::LEVEL_OPERATIVO]));
        $this->addReference('Formula-121', $formula);
            $manager->persist($formula);
            
        $formula = new Formula();
        $formula->setEnabled(true);
        $formula->setEquation('%TRP=(TM movilizadas/ TM planificadas) *100 ');
        $formula->setFormulaLevel($this->getReference($lineLevelArray[FormulaLevel::LEVEL_OPERATIVO]));
        $this->addReference('Formula-122', $formula);
            $manager->persist($formula);
            
        $formula = new Formula();
        $formula->setEnabled(true);
        $formula->setEquation('%PGCDBF= (Actividades Realizadas/Actividades Planificadas)*100');
        $formula->setFormulaLevel($this->getReference($lineLevelArray[FormulaLevel::LEVEL_OPERATIVO]));
        $this->addReference('Formula-123', $formula);
            $manager->persist($formula);
            
        $formula = new Formula();
        $formula->setEnabled(true);
        $formula->setEquation('%PGCDBPI= (Actividades Realizadas/Actividades Planificadas)*100');
        $formula->setFormulaLevel($this->getReference($lineLevelArray[FormulaLevel::LEVEL_OPERATIVO]));
        $this->addReference('Formula-124', $formula);
            $manager->persist($formula);
            
        $formula = new Formula();
        $formula->setEnabled(true);
        $formula->setEquation('%PGCDBOP= (Actividades Realizadas/Actividades Planificadas)*100');
        $formula->setFormulaLevel($this->getReference($lineLevelArray[FormulaLevel::LEVEL_OPERATIVO]));
        $this->addReference('Formula-125', $formula);
            $manager->persist($formula);
            
        $formula = new Formula();
        $formula->setEnabled(true);
        $formula->setEquation('%PDF=(Despachos ejecutados/Despachos planificados)*100');
        $formula->setFormulaLevel($this->getReference($lineLevelArray[FormulaLevel::LEVEL_OPERATIVO]));
        $this->addReference('Formula-126', $formula);
            $manager->persist($formula);
            
        $formula = new Formula();
        $formula->setEnabled(true);
        $formula->setEquation('%PDPI=(Despachos ejecutados/Despachos planificados)*100');
        $formula->setFormulaLevel($this->getReference($lineLevelArray[FormulaLevel::LEVEL_OPERATIVO]));
        $this->addReference('Formula-127', $formula);
            $manager->persist($formula);
            
        $formula = new Formula();
        $formula->setEnabled(true);
        $formula->setEquation('%PDOP=(Despachos ejecutados/Despachos planificados)*100');
        $formula->setFormulaLevel($this->getReference($lineLevelArray[FormulaLevel::LEVEL_OPERATIVO]));
        $this->addReference('Formula-128', $formula);
            $manager->persist($formula);
            
        $formula = new Formula();
        $formula->setEnabled(true);
        $formula->setEquation('%CPEF=(Producción ensacada real/producción ensacada planificada)*100');
        $formula->setFormulaLevel($this->getReference($lineLevelArray[FormulaLevel::LEVEL_OPERATIVO]));
        $this->addReference('Formula-129', $formula);
            $manager->persist($formula);
            
        $formula = new Formula();
        $formula->setEnabled(true);
        $formula->setEquation('(Ventas Int. Reales Fertilizantes / Ventas Int. Planificadas) x 100%');
        $formula->setFormulaLevel($this->getReference($lineLevelArray[FormulaLevel::LEVEL_OPERATIVO]));
        $this->addReference('Formula-130', $formula);
            $manager->persist($formula);
            
        $formula = new Formula();
        $formula->setEnabled(true);
        $formula->setEquation('(Ventas Int. Reales Productos Químicos / Ventas Int. Planificadas) x 100%');
        $formula->setFormulaLevel($this->getReference($lineLevelArray[FormulaLevel::LEVEL_OPERATIVO]));
        $this->addReference('Formula-131', $formula);
            $manager->persist($formula);
            
        $formula = new Formula();
        $formula->setEnabled(true);
        $formula->setEquation('(Ventas Int. Reales Resinas Plásticas) / Ventas Int. Planificadas) x 100%');
        $formula->setFormulaLevel($this->getReference($lineLevelArray[FormulaLevel::LEVEL_OPERATIVO]));
        $this->addReference('Formula-132', $formula);
            $manager->persist($formula);
            
        $formula = new Formula();
        $formula->setEnabled(true);
        $formula->setEquation(' % Cumplimimiento Ejec y Seg Plan de Ventas Int = Ventas Reales Ejecutadas / Ventas Planificadas * 100');
        $formula->setFormulaLevel($this->getReference($lineLevelArray[FormulaLevel::LEVEL_OPERATIVO]));
        $this->addReference('Formula-133', $formula);
            $manager->persist($formula);
            
        $formula = new Formula();
        $formula->setEnabled(true);
        $formula->setEquation('%CPEND = (Actividades Realizada PEND/ Actividades Planificadas PEND)*100');
        $formula->setFormulaLevel($this->getReference($lineLevelArray[FormulaLevel::LEVEL_OPERATIVO]));
        $this->addReference('Formula-134', $formula);
            $manager->persist($formula);
            
        $formula = new Formula();
        $formula->setEnabled(true);
        $formula->setEquation('No. de CEIFC= No. Informes Realizados');
        $formula->setFormulaLevel($this->getReference($lineLevelArray[FormulaLevel::LEVEL_OPERATIVO]));
        $this->addReference('Formula-135', $formula);
            $manager->persist($formula);
            
        $formula = new Formula();
        $formula->setEnabled(true);
        $formula->setEquation('No. CEIFH =  No. Informes Realizados');
        $formula->setFormulaLevel($this->getReference($lineLevelArray[FormulaLevel::LEVEL_OPERATIVO]));
        $this->addReference('Formula-136', $formula);
            $manager->persist($formula);
            
        $formula = new Formula();
        $formula->setEnabled(true);
        $formula->setEquation('No. CEISCG =  No. Informes Realizados');
        $formula->setFormulaLevel($this->getReference($lineLevelArray[FormulaLevel::LEVEL_OPERATIVO]));
        $this->addReference('Formula-137', $formula);
            $manager->persist($formula);
            
        $formula = new Formula();
        $formula->setEnabled(true);
        $formula->setEquation('%TPQC= (TM movilizadas/ TM planificadas) *100 ');
        $formula->setFormulaLevel($this->getReference($lineLevelArray[FormulaLevel::LEVEL_OPERATIVO]));
        $this->addReference('Formula-138', $formula);
            $manager->persist($formula);
            
        $formula = new Formula();
        $formula->setEnabled(true);
        $formula->setEquation('Convenio y Alianzas  Consolidados con las formalidades de ley / Convenios y Alianzas Consolidados* 100% ');
        $formula->setFormulaLevel($this->getReference($lineLevelArray[FormulaLevel::LEVEL_OPERATIVO]));
        $this->addReference('Formula-139', $formula);
            $manager->persist($formula);
            
        $formula = new Formula();
        $formula->setEnabled(true);
        $formula->setEquation('Actividades ejecutadas/ Actividades Planificadas/ *100 ');
        $formula->setFormulaLevel($this->getReference($lineLevelArray[FormulaLevel::LEVEL_OPERATIVO]));
        $this->addReference('Formula-140', $formula);
            $manager->persist($formula);
            
        $formula = new Formula();
        $formula->setEnabled(true);
        $formula->setEquation('Procedimientos ejecutados/Procedimientos Planificados/*100');
        $formula->setFormulaLevel($this->getReference($lineLevelArray[FormulaLevel::LEVEL_OPERATIVO]));
        $this->addReference('Formula-141', $formula);
            $manager->persist($formula);
            
        $formula = new Formula();
        $formula->setEnabled(true);
        $formula->setEquation('Contratos Elaborados Oportunamente / Contratos Elaborados *100');
        $formula->setFormulaLevel($this->getReference($lineLevelArray[FormulaLevel::LEVEL_OPERATIVO]));
        $this->addReference('Formula-142', $formula);
            $manager->persist($formula);
            
        $formula = new Formula();
        $formula->setEnabled(true);
        $formula->setEquation('Total de Asistencia a Comisiones / Total de Convocatorias a Reunión de Comisiones * 100');
        $formula->setFormulaLevel($this->getReference($lineLevelArray[FormulaLevel::LEVEL_OPERATIVO]));
        $this->addReference('Formula-143', $formula);
            $manager->persist($formula);
            
        $formula = new Formula();
        $formula->setEnabled(true);
        $formula->setEquation('Contratos Elaborados Oportunamente/Contratos Elaborados*100');
        $formula->setFormulaLevel($this->getReference($lineLevelArray[FormulaLevel::LEVEL_OPERATIVO]));
        $this->addReference('Formula-144', $formula);
            $manager->persist($formula);
            
        $formula = new Formula();
        $formula->setEnabled(true);
        $formula->setEquation('Total de Asistencia a Comisiones/total de Convocatorias a Reunión de Comisiones*100');
        $formula->setFormulaLevel($this->getReference($lineLevelArray[FormulaLevel::LEVEL_OPERATIVO]));
        $this->addReference('Formula-145', $formula);
            $manager->persist($formula);
            
        $formula = new Formula();
        $formula->setEnabled(true);
        $formula->setEquation('Contratos elaborados oportunamente / Contratos elaborados *100');
        $formula->setFormulaLevel($this->getReference($lineLevelArray[FormulaLevel::LEVEL_OPERATIVO]));
        $this->addReference('Formula-146', $formula);
            $manager->persist($formula);
            
        $formula = new Formula();
        $formula->setEnabled(true);
        $formula->setEquation('Total de asistencia a Comisión / Total a reuniones de Comisión *100');
        $formula->setFormulaLevel($this->getReference($lineLevelArray[FormulaLevel::LEVEL_OPERATIVO]));
        $this->addReference('Formula-147', $formula);
            $manager->persist($formula);
            
        $formula = new Formula();
        $formula->setEnabled(true);
        $formula->setEquation('Total de Procedimientos de planes de Vivienda apegados a la Ley / Total Procemimientos de planes de Vivienda * 100');
        $formula->setFormulaLevel($this->getReference($lineLevelArray[FormulaLevel::LEVEL_OPERATIVO]));
        $this->addReference('Formula-148', $formula);
            $manager->persist($formula);
            
        $formula = new Formula();
        $formula->setEnabled(true);
        $formula->setEquation('Asesorias Atentidas oportunamente / Asesorias Atendidas * 100');
        $formula->setFormulaLevel($this->getReference($lineLevelArray[FormulaLevel::LEVEL_OPERATIVO]));
        $this->addReference('Formula-149', $formula);
            $manager->persist($formula);
            
        $formula = new Formula();
        $formula->setEnabled(true);
        $formula->setEquation('Usuarios Satisfechos / Usuarios Atendidos *100');
        $formula->setFormulaLevel($this->getReference($lineLevelArray[FormulaLevel::LEVEL_OPERATIVO]));
        $this->addReference('Formula-150', $formula);
            $manager->persist($formula);
            
        $formula = new Formula();
        $formula->setEnabled(true);
        $formula->setEquation('Total de expedientes de PAAV atendidos oportunamente / Total de expedientes atendidos * 100');
        $formula->setFormulaLevel($this->getReference($lineLevelArray[FormulaLevel::LEVEL_OPERATIVO]));
        $this->addReference('Formula-151', $formula);
            $manager->persist($formula);
            
        $formula = new Formula();
        $formula->setEnabled(true);
        $formula->setEquation('Representaciones ejecutadas/representaciones requeridas*100');
        $formula->setFormulaLevel($this->getReference($lineLevelArray[FormulaLevel::LEVEL_OPERATIVO]));
        $this->addReference('Formula-152', $formula);
            $manager->persist($formula);
            
        $formula = new Formula();
        $formula->setEnabled(true);
        $formula->setEquation('CELCP = (Número de eventos ejecutados / Número de eventos  establecidos LCP) * 100');
        $formula->setFormulaLevel($this->getReference($lineLevelArray[FormulaLevel::LEVEL_OPERATIVO]));
        $this->addReference('Formula-153', $formula);
            $manager->persist($formula);
            
        $formula = new Formula();
        $formula->setEnabled(true);
        $formula->setEquation('CENI = (Número de eventos ejecutados  / Número de eventos establecidos en la Normativa Interna) * 100');
        $formula->setFormulaLevel($this->getReference($lineLevelArray[FormulaLevel::LEVEL_OPERATIVO]));
        $this->addReference('Formula-154', $formula);
            $manager->persist($formula);
            
        $formula = new Formula();
        $formula->setEnabled(true);
        $formula->setEquation('Confiabilidad = [1-(ΣProductos con desviación / ΣProductos)] * 100%');
        $formula->setFormulaLevel($this->getReference($lineLevelArray[FormulaLevel::LEVEL_OPERATIVO]));
        $this->addReference('Formula-155', $formula);
            $manager->persist($formula);
            
        $formula = new Formula();
        $formula->setEnabled(true);
        $formula->setEquation('Consignación Oportuna = (ΣProductos entregados oportunamente / ΣSolicitudes)');
        $formula->setFormulaLevel($this->getReference($lineLevelArray[FormulaLevel::LEVEL_OPERATIVO]));
        $this->addReference('Formula-156', $formula);
            $manager->persist($formula);
            
        $formula = new Formula();
        $formula->setEnabled(true);
        $formula->setEquation('Valor Objetivo = (ΣAcuerdos Establecidos/ΣAcuerdos Necesarios) * 100%');
        $formula->setFormulaLevel($this->getReference($lineLevelArray[FormulaLevel::LEVEL_OPERATIVO]));
        $this->addReference('Formula-157', $formula);
            $manager->persist($formula);
            
        $formula = new Formula();
        $formula->setEnabled(true);
        $formula->setEquation('(Compras Mensuales / Ctas. por Pagar) x Días a Evaluar');
        $formula->setFormulaLevel($this->getReference($lineLevelArray[FormulaLevel::LEVEL_OPERATIVO]));
        $this->addReference('Formula-158', $formula);
            $manager->persist($formula);
            
        $formula = new Formula();
        $formula->setEnabled(true);
        $formula->setEquation('(Cuentas Conciliadas / Total Cuentas a Conciliar) * 100');
        $formula->setFormulaLevel($this->getReference($lineLevelArray[FormulaLevel::LEVEL_OPERATIVO]));
        $this->addReference('Formula-159', $formula);
            $manager->persist($formula);
            
        $formula = new Formula();
        $formula->setEnabled(true);
        $formula->setEquation('(Cuentas Analizadas / Total Cuentas a Analizar) * 100');
        $formula->setFormulaLevel($this->getReference($lineLevelArray[FormulaLevel::LEVEL_OPERATIVO]));
        $this->addReference('Formula-160', $formula);
            $manager->persist($formula);
            
        $formula = new Formula();
        $formula->setEnabled(true);
        $formula->setEquation('Reclasificaciones realizadas en el 2014/ realizadas en el 2013*100');
        $formula->setFormulaLevel($this->getReference($lineLevelArray[FormulaLevel::LEVEL_OPERATIVO]));
        $this->addReference('Formula-161', $formula);
            $manager->persist($formula);
            
        $formula = new Formula();
        $formula->setEnabled(true);
        $formula->setEquation('(Consultas atendidas / Consultas realizadas) *100%');
        $formula->setFormulaLevel($this->getReference($lineLevelArray[FormulaLevel::LEVEL_OPERATIVO]));
        $this->addReference('Formula-162', $formula);
            $manager->persist($formula);
            
        $formula = new Formula();
        $formula->setEnabled(true);
        $formula->setEquation('(Total de Partidas No Identificadas /Total Partidas) *100');
        $formula->setFormulaLevel($this->getReference($lineLevelArray[FormulaLevel::LEVEL_OPERATIVO]));
        $this->addReference('Formula-163', $formula);
            $manager->persist($formula);
            
        $formula = new Formula();
        $formula->setEnabled(true);
        $formula->setEquation('(Total de comprobantes registrados en SAP / Total de comprobantes recuperados) * 100');
        $formula->setFormulaLevel($this->getReference($lineLevelArray[FormulaLevel::LEVEL_OPERATIVO]));
        $this->addReference('Formula-164', $formula);
            $manager->persist($formula);
            
        $formula = new Formula();
        $formula->setEnabled(true);
        $formula->setEquation('(Informes Evaluaciones de Crédito Actualizados / Total de Informes Evaluaciones de Crédito) * 80');
        $formula->setFormulaLevel($this->getReference($lineLevelArray[FormulaLevel::LEVEL_OPERATIVO]));
        $this->addReference('Formula-165', $formula);
            $manager->persist($formula);
            
        $formula = new Formula();
        $formula->setEnabled(true);
        $formula->setEquation('(Ctas por Pagar/Compras Mensuales) x 100');
        $formula->setFormulaLevel($this->getReference($lineLevelArray[FormulaLevel::LEVEL_OPERATIVO]));
        $this->addReference('Formula-166', $formula);
            $manager->persist($formula);
            
        $formula = new Formula();
        $formula->setEnabled(true);
        $formula->setEquation('(Cuentas Conciliadas / Total Cuentas a Conciliar) * 100');
        $formula->setFormulaLevel($this->getReference($lineLevelArray[FormulaLevel::LEVEL_OPERATIVO]));
        $this->addReference('Formula-167', $formula);
            $manager->persist($formula);
            
        $formula = new Formula();
        $formula->setEnabled(true);
        $formula->setEquation('(Nro. de requerimientos entregados en el lapso establecido/ Total de requerimientos solicitados) * 100');
        $formula->setFormulaLevel($this->getReference($lineLevelArray[FormulaLevel::LEVEL_OPERATIVO]));
        $this->addReference('Formula-168', $formula);
            $manager->persist($formula);
            
        $formula = new Formula();
        $formula->setEnabled(true);
        $formula->setEquation('(Noticias consignadas / Noticias concernientes) * 100');
        $formula->setFormulaLevel($this->getReference($lineLevelArray[FormulaLevel::LEVEL_OPERATIVO]));
        $this->addReference('Formula-169', $formula);
            $manager->persist($formula);
            
        $formula = new Formula();
        $formula->setEnabled(true);
        $formula->setEquation('(Documentos validados / Documentos recibidos) * 100');
        $formula->setFormulaLevel($this->getReference($lineLevelArray[FormulaLevel::LEVEL_OPERATIVO]));
        $this->addReference('Formula-170', $formula);
            $manager->persist($formula);
            
        $formula = new Formula();
        $formula->setEnabled(true);
        $formula->setEquation('(Información de Proyectos  consignada / Información de Proyectos requerida) * 100');
        $formula->setFormulaLevel($this->getReference($lineLevelArray[FormulaLevel::LEVEL_OPERATIVO]));
        $this->addReference('Formula-171', $formula);
            $manager->persist($formula);
            
        $formula = new Formula();
        $formula->setEnabled(true);
        $formula->setEquation('Información de Proyectos  consignada / Información de Proyectos requerida * 100');
        $formula->setFormulaLevel($this->getReference($lineLevelArray[FormulaLevel::LEVEL_OPERATIVO]));
        $this->addReference('Formula-172', $formula);
            $manager->persist($formula);
            
        $formula = new Formula();
        $formula->setEnabled(true);
        $formula->setEquation('PESID = (N° RSID<= 15 días / N° TSR) * 100');
        $formula->setFormulaLevel($this->getReference($lineLevelArray[FormulaLevel::LEVEL_OPERATIVO]));
        $this->addReference('Formula-173', $formula);
            $manager->persist($formula);
            
        $formula = new Formula();
        $formula->setEnabled(true);
        $formula->setEquation('PESVP = (N° RSVP<= 5 días hábiles / NT° SVP) * 100');
        $formula->setFormulaLevel($this->getReference($lineLevelArray[FormulaLevel::LEVEL_OPERATIVO]));
        $this->addReference('Formula-174', $formula);
            $manager->persist($formula);
            
        $formula = new Formula();
        $formula->setEnabled(true);
        $formula->setEquation('PESVPEMFP = (N° RSVPEMFP<= 8 días hábiles / NT° SVPEMFP) * 100');
        $formula->setFormulaLevel($this->getReference($lineLevelArray[FormulaLevel::LEVEL_OPERATIVO]));
        $this->addReference('Formula-175', $formula);
            $manager->persist($formula);
            
        $formula = new Formula();
        $formula->setEnabled(true);
        $formula->setEquation('PESVE = (N° RSVE<= 7 días hábiles / NT° SVE) * 100');
        $formula->setFormulaLevel($this->getReference($lineLevelArray[FormulaLevel::LEVEL_OPERATIVO]));
        $this->addReference('Formula-176', $formula);
            $manager->persist($formula);
            
        $formula = new Formula();
        $formula->setEnabled(true);
        $formula->setEquation('CPAREPF = (ΣEPFE/ΣEPFP) * 100');
        $formula->setFormulaLevel($this->getReference($lineLevelArray[FormulaLevel::LEVEL_OPERATIVO]));
        $this->addReference('Formula-177', $formula);
            $manager->persist($formula);
            
        $formula = new Formula();
        $formula->setEnabled(true);
        $formula->setEquation('CPAREC = (ΣECE/ΣECP) * 100');
        $formula->setFormulaLevel($this->getReference($lineLevelArray[FormulaLevel::LEVEL_OPERATIVO]));
        $this->addReference('Formula-178', $formula);
            $manager->persist($formula);
            
        $formula = new Formula();
        $formula->setEnabled(true);
        $formula->setEquation('EAD = (ΣDA/ΣDR) * 100');
        $formula->setFormulaLevel($this->getReference($lineLevelArray[FormulaLevel::LEVEL_OPERATIVO]));
        $this->addReference('Formula-179', $formula);
            $manager->persist($formula);
            
        $formula = new Formula();
        $formula->setEnabled(true);
        $formula->setEquation('CPEC = (ΣAPECE/ΣAPECP) * 100');
        $formula->setFormulaLevel($this->getReference($lineLevelArray[FormulaLevel::LEVEL_OPERATIVO]));
        $this->addReference('Formula-180', $formula);
            $manager->persist($formula);
            
        $formula = new Formula();
        $formula->setEnabled(true);
        $formula->setEquation('CPPAI = (ΣAPAIE/ΣAPAIP) * 100');
        $formula->setFormulaLevel($this->getReference($lineLevelArray[FormulaLevel::LEVEL_OPERATIVO]));
        $this->addReference('Formula-181', $formula);
            $manager->persist($formula);
            
        $formula = new Formula();
        $formula->setEnabled(true);
        $formula->setEquation('EIIG = (ΣIIO/ΣIIG) * 100');
        $formula->setFormulaLevel($this->getReference($lineLevelArray[FormulaLevel::LEVEL_OPERATIVO]));
        $this->addReference('Formula-182', $formula);
            $manager->persist($formula);
            
        $formula = new Formula();
        $formula->setEnabled(true);
        $formula->setEquation('CPTP = (ΣAPTPE/ΣAPTPP) * 100');
        $formula->setFormulaLevel($this->getReference($lineLevelArray[FormulaLevel::LEVEL_OPERATIVO]));
        $this->addReference('Formula-183', $formula);
            $manager->persist($formula);
            
        $formula = new Formula();
        $formula->setEnabled(true);
        $formula->setEquation('CPPI = (ΣAPPIE/ΣAPPIP) * 100');
        $formula->setFormulaLevel($this->getReference($lineLevelArray[FormulaLevel::LEVEL_OPERATIVO]));
        $this->addReference('Formula-184', $formula);
            $manager->persist($formula);
            
        $formula = new Formula();
        $formula->setEnabled(true);
        $formula->setEquation('BI = (ΣN° BI/ΣN° BR) * 100');
        $formula->setFormulaLevel($this->getReference($lineLevelArray[FormulaLevel::LEVEL_OPERATIVO]));
        $this->addReference('Formula-185', $formula);
            $manager->persist($formula);
            
        $formula = new Formula();
        $formula->setEnabled(true);
        $formula->setEquation('CPACG = (ΣAPACGE/ΣAPACGP) * 100');
        $formula->setFormulaLevel($this->getReference($lineLevelArray[FormulaLevel::LEVEL_OPERATIVO]));
        $this->addReference('Formula-186', $formula);
            $manager->persist($formula);
            
        $formula = new Formula();
        $formula->setEnabled(true);
        $formula->setEquation('MODELO CPJAA= Real/Plan*100');
        $formula->setFormulaLevel($this->getReference($lineLevelArray[FormulaLevel::LEVEL_OPERATIVO]));
        $this->addReference('Formula-187', $formula);
            $manager->persist($formula);
            
        $formula = new Formula();
        $formula->setEnabled(true);
        $formula->setEquation('MODELO EEMM= Real/Plan*100');
        $formula->setFormulaLevel($this->getReference($lineLevelArray[FormulaLevel::LEVEL_OPERATIVO]));
        $this->addReference('Formula-188', $formula);
            $manager->persist($formula);
            
        $formula = new Formula();
        $formula->setEnabled(true);
        $formula->setEquation('CUMP. REPORTES= Real/Plan*100');
        $formula->setFormulaLevel($this->getReference($lineLevelArray[FormulaLevel::LEVEL_OPERATIVO]));
        $this->addReference('Formula-189', $formula);
            $manager->persist($formula);
            
        $formula = new Formula();
        $formula->setEnabled(true);
        $formula->setEquation('DESARROLLO DE LA SALA= Real/Plan*100');
        $formula->setFormulaLevel($this->getReference($lineLevelArray[FormulaLevel::LEVEL_OPERATIVO]));
        $this->addReference('Formula-190', $formula);
            $manager->persist($formula);
            
        $formula = new Formula();
        $formula->setEnabled(true);
        $formula->setEquation('MODELO CPM= Real/Plan*100');
        $formula->setFormulaLevel($this->getReference($lineLevelArray[FormulaLevel::LEVEL_OPERATIVO]));
        $this->addReference('Formula-191', $formula);
            $manager->persist($formula);
            
        $formula = new Formula();
        $formula->setEnabled(true);
        $formula->setEquation('MODELO CPAMC= Real/Plan*100');
        $formula->setFormulaLevel($this->getReference($lineLevelArray[FormulaLevel::LEVEL_OPERATIVO]));
        $this->addReference('Formula-192', $formula);
            $manager->persist($formula);
            
        $formula = new Formula();
        $formula->setEnabled(true);
        $formula->setEquation('MODELO CORP= Real/Plan*100');
        $formula->setFormulaLevel($this->getReference($lineLevelArray[FormulaLevel::LEVEL_OPERATIVO]));
        $this->addReference('Formula-193', $formula);
            $manager->persist($formula);
            
        $formula = new Formula();
        $formula->setEnabled(true);
        $formula->setEquation('Gestión y Administración de Recursos= Real/Plan*100');
        $formula->setFormulaLevel($this->getReference($lineLevelArray[FormulaLevel::LEVEL_OPERATIVO]));
        $this->addReference('Formula-194', $formula);
            $manager->persist($formula);
            
        $formula = new Formula();
        $formula->setEnabled(true);
        $formula->setEquation('SGD = Real/Plan*100');
        $formula->setFormulaLevel($this->getReference($lineLevelArray[FormulaLevel::LEVEL_OPERATIVO]));
        $this->addReference('Formula-195', $formula);
            $manager->persist($formula);
            
        $formula = new Formula();
        $formula->setEnabled(true);
        $formula->setEquation('% Procesamiento = Solicitudes procesadas/ Solicitudes recibidas*100');
        $formula->setFormulaLevel($this->getReference($lineLevelArray[FormulaLevel::LEVEL_OPERATIVO]));
        $this->addReference('Formula-196', $formula);
            $manager->persist($formula);
            
        $formula = new Formula();
        $formula->setEnabled(true);
        $formula->setEquation('% Cumplimiento = Real/(Planificado + Solicitudes adicionales)*100');
        $formula->setFormulaLevel($this->getReference($lineLevelArray[FormulaLevel::LEVEL_OPERATIVO]));
        $this->addReference('Formula-197', $formula);
            $manager->persist($formula);
            
        $formula = new Formula();
        $formula->setEnabled(true);
        $formula->setEquation('% Atención = Solicitudes atendidas/Solicitudes asignadas*100');
        $formula->setFormulaLevel($this->getReference($lineLevelArray[FormulaLevel::LEVEL_OPERATIVO]));
        $this->addReference('Formula-198', $formula);
            $manager->persist($formula);
            
        $formula = new Formula();
        $formula->setEnabled(true);
        $formula->setEquation('(Requerimiento Alcanzado * Tiempo Alcanzado / Requerimiento Esperado * Estándar de Tiempo) * 100');
        $formula->setFormulaLevel($this->getReference($lineLevelArray[FormulaLevel::LEVEL_OPERATIVO]));
        $this->addReference('Formula-199', $formula);
            $manager->persist($formula);
            
        $formula = new Formula();
        $formula->setEnabled(true);
        $formula->setEquation('Días promedio de selección ');
        $formula->setFormulaLevel($this->getReference($lineLevelArray[FormulaLevel::LEVEL_OPERATIVO]));
        $this->addReference('Formula-200', $formula);
            $manager->persist($formula);
            
        $formula = new Formula();
        $formula->setEnabled(true);
        $formula->setEquation('Avance del Plan de Ingreso / Plan de Ingreso * 100');
        $formula->setFormulaLevel($this->getReference($lineLevelArray[FormulaLevel::LEVEL_OPERATIVO]));
        $this->addReference('Formula-201', $formula);
            $manager->persist($formula);
            
        $formula = new Formula();
        $formula->setEnabled(true);
        $formula->setEquation('Eficacia de la Capacitación = (Promedio Ponderado) Calificaciones + Medición de Competencias');
        $formula->setFormulaLevel($this->getReference($lineLevelArray[FormulaLevel::LEVEL_OPERATIVO]));
        $this->addReference('Formula-202', $formula);
            $manager->persist($formula);
            
        $formula = new Formula();
        $formula->setEnabled(true);
        $formula->setEquation('Planes de acción del Supervisor cumplidos / Planes de acción del supervisor programados');
        $formula->setFormulaLevel($this->getReference($lineLevelArray[FormulaLevel::LEVEL_OPERATIVO]));
        $this->addReference('Formula-203', $formula);
            $manager->persist($formula);
            
        $formula = new Formula();
        $formula->setEnabled(true);
        $formula->setEquation('Avance del Programa de Optimización  / Programa Planificado * 100');
        $formula->setFormulaLevel($this->getReference($lineLevelArray[FormulaLevel::LEVEL_OPERATIVO]));
        $this->addReference('Formula-204', $formula);
            $manager->persist($formula);
            
        $formula = new Formula();
        $formula->setEnabled(true);
        $formula->setEquation('Total de Horas Extras Trabajadas / Total de Horas Normales de Trabajo * 100');
        $formula->setFormulaLevel($this->getReference($lineLevelArray[FormulaLevel::LEVEL_OPERATIVO]));
        $this->addReference('Formula-205', $formula);
            $manager->persist($formula);
            
        $formula = new Formula();
        $formula->setEnabled(true);
        $formula->setEquation('Total de Beneficios + Bienestar / Labor Directa + Labor Indirecta');
        $formula->setFormulaLevel($this->getReference($lineLevelArray[FormulaLevel::LEVEL_OPERATIVO]));
        $this->addReference('Formula-206', $formula);
            $manager->persist($formula);
            
        $formula = new Formula();
        $formula->setEnabled(true);
        $formula->setEquation('(Iniciativas con alianzas estratégicas / Total de iniciativas planificadas) * 100');
        $formula->setFormulaLevel($this->getReference($lineLevelArray[FormulaLevel::LEVEL_OPERATIVO]));
        $this->addReference('Formula-207', $formula);
            $manager->persist($formula);
            
        $formula = new Formula();
        $formula->setEnabled(true);
        $formula->setEquation('(Solicitudes Alcanzadas * Tiempo Alcanzado / Solicitudes Esperadas * Estándar de Tiempo) * 100');
        $formula->setFormulaLevel($this->getReference($lineLevelArray[FormulaLevel::LEVEL_OPERATIVO]));
        $this->addReference('Formula-208', $formula);
            $manager->persist($formula);
            
        $formula = new Formula();
        $formula->setEnabled(true);
        $formula->setEquation('(Cantidad de Reembolsos procesados/Cantidad de solicitudes de reembolso recibidas)*100');
        $formula->setFormulaLevel($this->getReference($lineLevelArray[FormulaLevel::LEVEL_OPERATIVO]));
        $this->addReference('Formula-209', $formula);
            $manager->persist($formula);
            
        $formula = new Formula();
        $formula->setEnabled(true);
        $formula->setEquation('(Cantidad de Cartas Avales Iniciales procesadas/Cantidad de Solicitudes de cartas Avales Iniciales recibidas)*100');
        $formula->setFormulaLevel($this->getReference($lineLevelArray[FormulaLevel::LEVEL_OPERATIVO]));
        $this->addReference('Formula-210', $formula);
            $manager->persist($formula);
            
        $formula = new Formula();
        $formula->setEnabled(true);
        $formula->setEquation('(Cantidad de Facturas procesadas/Cantidad de Facturas recibidas)*100');
        $formula->setFormulaLevel($this->getReference($lineLevelArray[FormulaLevel::LEVEL_OPERATIVO]));
        $this->addReference('Formula-211', $formula);
            $manager->persist($formula);
            
        $formula = new Formula();
        $formula->setEnabled(true);
        $formula->setEquation('Avance = (Avance Ejecutado/Avance Programado)*100');
        $formula->setFormulaLevel($this->getReference($lineLevelArray[FormulaLevel::LEVEL_OPERATIVO]));
        $this->addReference('Formula-212', $formula);
            $manager->persist($formula);
            
        $formula = new Formula();
        $formula->setEnabled(true);
        $formula->setEquation('Avance= (Indice logrado/Indice programado) ');
        $formula->setFormulaLevel($this->getReference($lineLevelArray[FormulaLevel::LEVEL_OPERATIVO]));
        $this->addReference('Formula-213', $formula);
            $manager->persist($formula);
            
        $formula = new Formula();
        $formula->setEnabled(true);
        $formula->setEquation('Avance= (Accidentes investigados/Accidentes Ocurridos)');
        $formula->setFormulaLevel($this->getReference($lineLevelArray[FormulaLevel::LEVEL_OPERATIVO]));
        $this->addReference('Formula-214', $formula);
            $manager->persist($formula);
            
        $formula = new Formula();
        $formula->setEnabled(true);
        $formula->setEquation('(Informes entregados / Informes necesarios)*100');
        $formula->setFormulaLevel($this->getReference($lineLevelArray[FormulaLevel::LEVEL_OPERATIVO]));
        $this->addReference('Formula-215', $formula);
            $manager->persist($formula);
            
        $formula = new Formula();
        $formula->setEnabled(true);
        $formula->setEquation('(Solicitudes de permisos entregados  / Permisos requeridos)*100');
        $formula->setFormulaLevel($this->getReference($lineLevelArray[FormulaLevel::LEVEL_OPERATIVO]));
        $this->addReference('Formula-216', $formula);
            $manager->persist($formula);
            
        $manager->flush();
    }
    
    public function getOrder(){
        return 12;
        
    }
    
    public function setContainer(ContainerInterface $container = null) {
        $this->container = $container;
    }
}