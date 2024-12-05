<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consentimiento Informado</title>

    <!-- Sección para mostrar la fecha y hora de generación del reporte -->
<div class="report-info">
    Fecha: {{ \Carbon\Carbon::now()->locale('es')->isoFormat('D [de] MMMM [de] YYYY') }} &nbsp; &nbsp;
    Hora: {{ \Carbon\Carbon::now()->format('h:i:s A') }}
</div>

    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .logo {
            max-width: 150px;
        }
        .content {
            margin: 20px 0;
        }
        .datos-paciente, .content p {
            margin-bottom: 10px;
        }
        .signature {
            margin-top: 50px;
        }
    </style>
</head>
<body>
    <div class="header">
        <!-- Logo si tienes uno, puedes agregarlo aquí -->
        
        <h1>Consentimiento Informado</h1>
    </div>

    <div class="content">
        <p><strong>Médico:</strong> {{ $consentimiento->medico->name }}</p>

        <div class="datos-paciente">
            <p><strong>Nombre del paciente:</strong> {{ $patientName }}</p>
            <p><strong>Edad:</strong> {{ $patientEdad }} años</p>
        </div>

        <p><strong>Contenido:</strong> {{ $consentimiento->contenido }}</p>

        <p><strong>Procedimientos a realizar:</strong> </p>
        <p>1. Entiendo que me harán el siguiente trabajo: 
            Empastes ( ) Puentes ( ) Coronas ( ), Rayos X ( ) Extracciones ( ) Extracción de dientes incrustados ( ) Endodoncia ( ) Dentadura postiza ( ) Otros ( ) ____________________.
            Iniciales de Paciente___________
        </p>

        <p>2. <strong>Fármacos y Medicamentos:</strong> Entiendo que los antibióticos, analgésicos y otros medicamentos podrían causar reacciones alérgicas. He informado a mi dentista de todos los medicamentos que estoy tomando actualmente. Iniciales Paciente ___________ </p>

        <p>3. <strong>Extracción de dientes:</strong> Las alternativas a la extracción me han sido explicadas y autorizo al dentista a extraer los dientes siguientes: _________________________, y cualquier otros que fuesen necesarios. Iniciales Paciente ________ </p>

        <p>4.<strong>Cambios en el plande tratamiento:</strong>Entiendo que durante el tratamiento podría precisarse cambiar
            o añadir procedimientos debido a las condiciones halladas mientras el dentista este trabajando en los dientes
            que no pudieran haber sido descubiertas durante exámenes previos. Por ejemplo, la terapia de endodoncia podría
            precisarse tras un procedimiento restaurativo de rutina. Doy mi permiso a mi dentista para que haga
            cualquier/todo cambio y adiciones como sea necesario. Iniciales Paciente ___________ 
        </p>

        <p><strong>Coronas, puentes y fundas:</strong>Entiendo que a veces no es posible igualar el color de los dientes
            naturales con dientes artificiales. Además, entiendo que podría llevar coronas temporales, que podrían salirse
            fácilmente and tengo que tener cuidado de guardarlas hasta que se me entreguen las coronas permanentes.
            Asumo que la última oportunidad de hacer cambios en las nuevas coronas, puentes, o fundas (incluyendo la
            forma, encaje y color) solo podrá ocurrir antes de la cementación final. Soy responsable de volver para la
            cementación dentro de los 21 días a partir de la fecha de preparación del diente. Retrasos excesivos podría
            producir que el diente se moviera lo cual precisaría volver a hacer la corona, puente, o funda. En dichas
            circunstancias, entiendo que se producirán cargos adicionales para hacer una nueva pieza debido a mi retraso
            en ir al dentista para la cementación permanente. Iniciales Paciente ______________ 

        </p>

        <p>{{ $consentimiento->contenido }}</p>
        
        <p>
            Declaro que he sido informado en un lenguaje claro y comprensible acerca del procedimiento y los posibles riesgos, así como de las alternativas disponibles. También he tenido la oportunidad de hacer preguntas y aclarar dudas con el profesional dental a cargo.
        </p>
    </div>

    <div class="signature">
        <p>Firma del Paciente: __________________________</p>
        <p>Firma del Médico: __________________________</p>
    </div>
</body>
</html>
