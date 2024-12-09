<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\CursosModel;
use Illuminate\Support\Str; // Asegúrate de importar Str

class MencionController extends Controller
{
    public function index()
    {
        // Lista de menciones (puedes cargarlas dinámicamente si las tienes en una tabla)
        $menciones = [
            'Medicina de Emergencia y Desastres',
            'Pediatría',
            'Radiología',
            'Medicina Interna',
            'Medicina Familiar y Comunitaria',
            'Ortopedia y Traumatología',
            'Anestesiología',
            'Cirugía General',
            'Ginecología y Obstetricia',
        ];

        // Retorna la vista con las menciones
        return view('welcome', compact('menciones'));
    }

    /**
     * Muestra los cursos relacionados con una mención específica.
     *
     * @param  string  $slug
     * @return \Illuminate\View\View
     */

    public function mostrarCursos($slug)
    {
        // Mapeo de slugs a títulos originales
        $slugToTitleMap = [
            'medicina-de-emergencia-y-desastres' => 'Medicina de Emergencia y Desastres',
            'pediatria' => 'Pediatría',
            'radiologia' => 'Radiología',
            'medicina-interna' => 'Medicina Interna',
            'medicina-familiar-y-comunitaria' => 'Medicina Familiar y Comunitaria',
            'ortopedia-y-traumatologia' => 'Ortopedia y Traumatología',
            'anestesiologia' => 'Anestesiología',
            'cirugia-general' => 'Cirugía General',
            'ginecologia-y-obstetricia' => 'Ginecología y Obstetricia',
        ];

        // Convertir el slug en el nombre original de la mención
        $mencion = $slugToTitleMap[$slug] ?? 'Mención no disponible';

        // Buscar los cursos relacionados con la mención
        $cursos = CursosModel::where('mension', $mencion)->get();

        // Descripción detallada de cada mención
        $descripciones = [
            'Medicina de Emergencia y Desastres' => 'La mención en Medicina de Emergencia y Desastres está diseñada para capacitar a médicos residentes en la atención rápida y eficaz ante situaciones de crisis, accidentes y desastres naturales. En la región altiplánica, con su clima extremo y condiciones geográficas complejas, los profesionales necesitan habilidades especiales para gestionar emergencias, desde accidentes vehiculares hasta desastres como inundaciones y deslizamientos. Esta especialidad se enfoca en brindar los conocimientos necesarios para evaluar y tratar pacientes en situaciones críticas, además de coordinar respuestas a gran escala con equipos multidisciplinarios.

Durante el residentado, los médicos aprenderán a liderar en situaciones de urgencia, manejando recursos limitados y tomando decisiones críticas en escenarios de alta presión. La formación incluye capacitación en reanimación avanzada, manejo de trauma, y la planificación y ejecución de simulacros de desastres, con un enfoque particular en las emergencias que afectan a la región de Puno y sus zonas aledañas.',
            'Pediatría' => 'La mención en Pediatría tiene como objetivo formar especialistas que puedan abordar integralmente las necesidades de salud de los niños en el altiplano peruano. Dado el contexto socioeconómico de la región, los pediatras deben estar preparados para enfrentar no solo enfermedades comunes en la infancia, sino también las que resultan de condiciones ambientales, como las infecciones respiratorias agudas, la desnutrición y el retraso en el desarrollo debido a la altitud.

Durante el residentado, los médicos adquirirán competencias en el manejo de patologías complejas y crónicas en niños, con especial atención en enfermedades endémicas de la región, inmunizaciones, y la implementación de programas de salud pública infantil. También se enfoca en el desarrollo de habilidades en atención neonatal y el manejo de emergencias pediátricas en entornos rurales, donde la infraestructura sanitaria es limitada.',
            'Radiología' => 'La mención en Radiología ofrece una formación integral en el uso de técnicas avanzadas de diagnóstico por imagen, cruciales en el contexto del altiplano, donde las barreras geográficas y la distancia de centros especializados pueden retrasar el diagnóstico de enfermedades. Los residentes serán entrenados en la interpretación de estudios de rayos X, tomografía computarizada (TC), resonancia magnética (RM), y ultrasonido, herramientas esenciales para la detección temprana de enfermedades prevalentes en la región.

En este programa, los médicos aprenderán a utilizar la tecnología de imagen para diagnosticar enfermedades crónicas, como la tuberculosis y patologías pulmonares, comunes en zonas de alta altitud. Además, se les capacitará en la detección de traumatismos y enfermedades degenerativas, brindando a los residentes las herramientas necesarias para contribuir al diagnóstico y tratamiento oportuno en áreas rurales y urbanas de Puno.',
            'Medicina Interna' => 'La mención en Medicina Interna prepara a los residentes para gestionar una amplia gama de patologías complejas que afectan a la población adulta en el altiplano. Debido a las características geográficas y climáticas de la región, la prevalencia de enfermedades respiratorias, cardiovasculares y metabólicas es alta. Este programa se enfoca en proporcionar un enfoque integral al diagnóstico y tratamiento de estas patologías, desarrollando habilidades en el manejo de enfermedades crónicas y múltiples comorbilidades.

Durante su formación, los residentes aprenderán a tomar decisiones clínicas basadas en la evidencia, priorizando el bienestar integral del paciente. Además, se hace énfasis en el manejo de enfermedades prevalentes en la región, como la hipertensión arterial, diabetes y enfermedades pulmonares crónicas, brindando una atención especializada a los habitantes de las zonas rurales, que muchas veces no tienen acceso a servicios de salud complejos.',
            'Medicina Familiar y Comunitaria' => 'La mención en Medicina Familiar y Comunitaria es fundamental para formar médicos que actúen como el primer punto de contacto en el sistema de salud, especialmente en áreas rurales de Puno. Los residentes adquirirán habilidades para atender a personas de todas las edades, con un enfoque holístico que integre la promoción de la salud, la prevención de enfermedades y el tratamiento continuo de pacientes con múltiples condiciones.

Este programa se enfoca en capacitar a los residentes para trabajar en estrecha colaboración con comunidades, diseñando e implementando estrategias de salud pública que aborden las necesidades específicas de la población. Se presta especial atención a la atención primaria, el cuidado longitudinal y la relación médico-paciente, esenciales en áreas donde la atención médica especializada es menos accesible.',
            'Ortopedia y Traumatología' => 'La mención en Ortopedia y Traumatología ofrece a los médicos residentes una formación sólida en el diagnóstico y tratamiento de lesiones del sistema musculoesquelético, como fracturas, dislocaciones y enfermedades degenerativas. En el contexto de Puno, donde los accidentes laborales y de tránsito son frecuentes debido a las características geográficas y climáticas, la capacidad de brindar atención ortopédica oportuna es esencial.

Durante el residentado, los médicos aprenderán tanto técnicas quirúrgicas avanzadas como métodos de rehabilitación para asegurar una recuperación óptima del paciente. Además, se enfatiza el tratamiento de lesiones deportivas, enfermedades óseas y articulares crónicas, y la atención de emergencias ortopédicas en zonas con infraestructura médica limitada.',
            'Anestesiología' => 'La mención en Anestesiología proporciona a los residentes una formación exhaustiva en la administración de anestesia durante procedimientos quirúrgicos y el manejo del dolor agudo. En una región como Puno, donde el acceso a recursos médicos puede ser limitado, los anestesiólogos deben estar preparados para trabajar en condiciones de alta presión y con recursos reducidos.

Los residentes se especializarán en anestesia general y regional, con un enfoque particular en el manejo de pacientes en situaciones de emergencia y cirugías complejas. Además, se les capacitará en el manejo de complicaciones intraoperatorias y en la monitorización avanzada de pacientes, asegurando que puedan brindar una atención segura y efectiva tanto en centros médicos grandes como en áreas más remotas.',
            'Cirugía General' => 'La mención en Cirugía General forma a los residentes en una amplia gama de intervenciones quirúrgicas, desde procedimientos de emergencia hasta cirugías programadas. La región de Puno, con su geografía accidentada y la frecuencia de traumas debido a accidentes, demanda cirujanos que puedan manejar eficazmente situaciones críticas.

El residentado se centra en desarrollar habilidades en cirugías abdominales, gastrointestinales, oncológicas y vasculares, con una fuerte base en la toma de decisiones quirúrgicas y el manejo postoperatorio de los pacientes. Se enfatiza la importancia de la atención quirúrgica en áreas rurales, donde los recursos pueden ser escasos, preparando a los residentes para trabajar en una amplia variedad de entornos clínicos.',
            'Ginecología y Obstetricia' => 'La mención en Ginecología y Obstetricia se enfoca en formar médicos especialistas en el cuidado integral de la salud reproductiva de las mujeres, desde el manejo del embarazo hasta el tratamiento de enfermedades ginecológicas. En Puno, donde la tasa de mortalidad materna puede ser más alta debido a la falta de acceso a servicios médicos oportunos, este programa busca mejorar la atención a mujeres en todo el ciclo reproductivo.

Durante el residentado, los médicos se capacitan en atención prenatal, manejo del parto y cesáreas, así como en el tratamiento de trastornos ginecológicos, tanto benignos como malignos. También se pone un fuerte énfasis en la educación en salud sexual y reproductiva, con el fin de mejorar los indicadores de salud de las mujeres en la región.',
        ];

        // Obtener la descripción de la mención
        $descripcion = $descripciones[$mencion] ?? 'Descripción no disponible.';

        // Retornar la vista con los cursos y la descripción de la mención
        return view('layouts.frontend.cursos', compact('mencion', 'cursos', 'descripcion'));
    }


}
