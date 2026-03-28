<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: Arial, sans-serif; font-size: 11px; color: #333; }
        .header { text-align: center; margin-bottom: 20px; border-bottom: 2px solid #6366f1; padding-bottom: 10px; }
        .header h1 { font-size: 20px; color: #6366f1; margin: 0; }
        .header h2 { font-size: 14px; color: #666; margin: 5px 0 0; font-weight: normal; }
        .info-grid { display: flex; gap: 15px; margin-bottom: 20px; }
        .info-box { flex: 1; background: #f8f9fa; border: 1px solid #dee2e6; border-radius: 6px; padding: 10px; }
        .info-label { font-size: 10px; color: #666; text-transform: uppercase; }
        .info-value { font-size: 13px; font-weight: bold; color: #333; margin-top: 2px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        thead { background: #6366f1; color: white; }
        th { padding: 8px 6px; text-align: center; font-size: 10px; text-transform: uppercase; }
        th.left { text-align: left; }
        tbody tr:nth-child(even) { background: #f8f9fa; }
        td { padding: 8px 6px; border-bottom: 1px solid #dee2e6; font-size: 11px; text-align: center; }
        td.left { text-align: left; }
        .badge { padding: 2px 7px; border-radius: 4px; font-size: 10px; font-weight: bold; }
        .badge-ok { background: #d1fae5; color: #065f46; }
        .badge-riesgo { background: #fee2e2; color: #991b1b; }
        .footer { margin-top: 30px; text-align: center; font-size: 10px; color: #999; border-top: 1px solid #dee2e6; padding-top: 10px; }
        .criterio-header { font-size: 9px; }
        .peso { font-size: 9px; color: #6366f1; display: block; }
    </style>
</head>
<body>
    <div class="header">
        <h1>AsistenciaT — Reporte de Calificaciones</h1>
        <h2>{{ $grupo->materia->nombre }} · Grupo {{ $grupo->clave }} · {{ $grupo->semestre->nombre }}</h2>
    </div>
    <div class="info-grid">
        <div class="info-box">
            <div class="info-label">Maestro</div>
            <div class="info-value">{{ $grupo->maestro->name }}</div>
        </div>
        <div class="info-box">
            <div class="info-label">Total alumnos</div>
            <div class="info-value">{{ $grupo->alumnos->count() }}</div>
        </div>
        <div class="info-box">
            <div class="info-label">Criterios</div>
            <div class="info-value">{{ $criterios->count() }}</div>
        </div>
        <div class="info-box">
            <div class="info-label">Fecha de reporte</div>
            <div class="info-value">{{ now()->format('d/m/Y') }}</div>
        </div>
    </div>
    <table>
        <thead>
            <tr>
                <th class="left">#</th>
                <th class="left">Alumno</th>
                <th class="left">Matrícula</th>
                @foreach($criterios as $criterio)
                <th class="criterio-header">
                    {{ $criterio->nombre }}
                    <span class="peso">{{ $criterio->peso }}%</span>
                </th>
                @endforeach
                <th>Promedio</th>
                <th>Estado</th>
            </tr>
        </thead>
        <tbody>
            @foreach($reporteAlumnos as $i => $item)
            <tr>
                <td class="left">{{ $i + 1 }}</td>
                <td class="left">{{ $item['alumno']->name }}</td>
                <td class="left">{{ $item['alumno']->matricula ?? '—' }}</td>
                @foreach($criterios as $criterio)
                <td>
                    @if($item['calificaciones'][$criterio->id] !== null)
                        <strong style="color: {{ $item['calificaciones'][$criterio->id] >= 60 ? '#065f46' : '#991b1b' }}">
                            {{ $item['calificaciones'][$criterio->id] }}
                        </strong>
                    @else
                        <span style="color: #999">—</span>
                    @endif
                </td>
                @endforeach
                <td>
                    @if($item['promedio'] !== null)
                        <strong style="color: {{ $item['promedio'] >= 60 ? '#065f46' : '#991b1b' }}; font-size: 13px;">
                            {{ $item['promedio'] }}
                        </strong>
                    @else
                        <span style="color: #999">—</span>
                    @endif
                </td>
                <td>
                    @if($item['promedio'] !== null)
                        <span class="badge {{ $item['promedio'] >= 60 ? 'badge-ok' : 'badge-riesgo' }}">
                            {{ $item['promedio'] >= 60 ? 'Aprobado' : 'Reprobado' }}
                        </span>
                    @else
                        <span style="color: #999">Pendiente</span>
                    @endif
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
