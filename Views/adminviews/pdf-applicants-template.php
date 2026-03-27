<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Reporte de Aplicantes</title>
    <style>
        body { font-family: 'Helvetica', sans-serif; color: #333; }
        .header { text-align: center; margin-bottom: 30px; border-bottom: 1px solid #eee; padding-bottom: 10px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 12px; text-align: left; font-size: 12px; }
        th { background-color: #f8f9fa; font-weight: bold; text-transform: uppercase; }
        .status-active { color: #28a745; font-weight: bold; }
        .status-declined { color: #dc3545; font-weight: bold; }
        .footer { margin-top: 30px; text-align: right; font-size: 10px; color: #777; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Lista de Applicantes</h1>
        <h2>Oferta: <?php echo $jobOffer->getTitle(); ?></h2>
        <p>Generada el: <?php echo date('d/m/Y H:i'); ?></p>
    </div>

    <table>
        <thead>
            <tr>
                <th>Nombre del Estudiante</th>
                <th>Email</th>
                <th>Fecha de Aplicación</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php if(!empty($applicantList)) { 
                foreach($applicantList as $student) { ?>
                <tr>
                    <td><?php echo $student['firstName'] . " " . $student['lastName']; ?></td>
                    <td><?php echo $student['email']; ?></td>
                    <td><?php echo date('d/m/Y', strtotime($student['applicationDate'])); ?></td>
                    <td>
                        <span class="<?php echo ($student['status'] == 'declined') ? 'status-declined' : 'status-active'; ?>">
                            <?php echo strtoupper($student['status']); ?>
                        </span>
                    </td>
                </tr>
            <?php } 
            } else { ?>
                <tr><td colspan="4" style="text-align: center;">Sin aplicantes encontrados para esta oferta.</td></tr>
            <?php } ?>
        </tbody>
    </table>

    <div class="footer">
        <p>System: Let's Work - University Job Board</p>
    </div>
</body>
</html>