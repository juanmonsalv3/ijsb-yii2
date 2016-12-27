Create VIEW Vw_UltimoGrupoEstudiante as
select max(anio) anio, id_estudiante from grupos_estudiantes group by id_estudiante