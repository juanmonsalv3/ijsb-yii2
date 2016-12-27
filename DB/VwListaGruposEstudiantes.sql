Create View VwListaGruposEstudiantes As
SELECT 
	e.id_estudiante
	,e.nombres
	,e.apellidos
	,e.fecha_nacimiento
	,e.ciudad_nacimiento
	,e.activo
	,e.id_inscripcion
	,e.sexo
	,ge.anio
	,ge.id_grupo
	,ge.estado 
FROM GRUPOS_ESTUDIANTES GE
INNER JOIN VW_ULTIMOGRUPOESTUDIANTE VUE ON (GE.ID_ESTUDIANTE = VUE.ID_ESTUDIANTE AND GE.ANIO = VUE.ANIO) 
RIGHT JOIN ESTUDIANTES E ON (E.ID_ESTUDIANTE = GE.ID_ESTUDIANTE)
ORDER BY GE.ANIO 