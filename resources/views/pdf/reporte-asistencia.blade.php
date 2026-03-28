<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; color: #333; }
        .header { text-align: center; margin-bottom: 20px; border-bottom: 2px solid #6366f1; padding-bottom: 10px; }
        .header h1 { font-size: 20px; color: #6366f1; margin: 0; }
        .header h2 { font-size: 14px; color: #666; margin: 5px 0 0; font-weight: normal; }
        .info-grid { display: flex; gap: 15px; margin-bottom: 20px; }
        .info-box { flex: 1; background: #f8f9fa; border: 1px solid #dee2e6; border-radius: 6px; padding: 10px; }
        .info-label { font-size: 10px; color: #666; text-transform: uppercase; }
        .info-value { font-size: 13px; font-weight: bold; color: #333; margin-top: 2px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        thead { background: #6366f1; color: white; }
        th { padding: 10px 8px; text-align: left; font-size: 11px; text-transform: uppercase; }
        tbody tr:nth-child(even) { background: #f8f9fa; }
        td { padding: 9px 8px; border-bottom: 1px solid #dee2e6; font-size: 12px; }
        .badge { padding: 3px 8px; border-radius: 4px; font-size: 10px; font-weight: bold; }
        .badge-ok { background: #d1fae5; color: #065f46; }
        .badge-riesgo { background: #fee2e2; color: #991b1b; }
        .footer { margin-top: 30px; text-align: center; font-size: 10px; color: #999; border-top: 1px solid #dee2e6; padding-top: 10px; }
    </style>
</head>
<body>
    <div class="header">
        <h1>AsistenciaT — Reporte de Asistencia</h1>
        <h2>{{ $grupo->materia->nombre }} · Grupo {{ $grupo->clave }} · {{ $grupo->semestre->nombre }}</h2>
    </div>
    <div class="info-grid">
        <div class="info-box">
            <div class="info-label">Maestro</div>
            <div class="info-value">{{ $grupo->maestro->name }}</div>
        </div>
        <div class="info-box">
            <div class="info-label">Sesiones realizadas</div>
            <div class="info-value">{{ $sesionesRealizadas }}</div>
        </div>
        <div class="info-box">
            <div class="info-label">Total alumnos</div>
            <div class="info-value">{{ $grupo->alumnos->count() }}</div>
        </div>
        <div class="info-box">
            <div class="info-label">Asistencia mínima</div>
            <div class="info-value">{{ $grupo->porcentaje_asistencia_minima }}%</div>
        </div>
        <div class="info-box">
            <div class="info-label">Fecha de reporte</div>
            <div class="info-value">{{ now()->format('d/m/Y') }}</div>
        </div>
    </div>
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Alumno</th>
                <th>Matrícula</th>
                <th>Presentes</th>
                <th>Faltas</th>
                <th>% Asistencia</th>
                <th>Estado</th>
            </tr>
        </thead>
        <tbody>
            @foreach($reporteAlumnos as $i => $item)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td>{{ $item['alumno']->name }}</td>
                <td>{{ $item['alumno']->matricula ?? '—' }}</td>
                <td style="color: #065f46; font-weight: bold">{{ $item['presentes'] }}</td>
                <td style="color: #991b1b; font-weight: bold">{{ $item['faltas'] }}</td>
                <td>
                    <strong style="color: {{ $item['aprobado'] ? '#065f46' : '#991b1b' }}">
                        {{ $item['porcentaje'] }}%
                    </strong>
                </td>
                <td>
                    <span class="badge {{ $item['aprobado'] ? 'badge-ok' : 'badge-riesgo' }}">
                        {{ $item['aprobado'] ? 'Regular' : 'En riesgo' }}
                    </span>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div class="footer">
        Generado por AsistenciaT · {{ now()->format('d/m/Y H:i') }} · {{ $grupo->maestro->name }}
    </div>
</body>
</html>
