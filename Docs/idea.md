## CRUD DE CERTIFICADOS


vamos a construir paso a paso un CRUD primero crear una migracion para los certificados, con los siguientes campos que tenga el softdelete tambien
- nombre 
- institución
- fecha_inicio
- fecha_conclusion
- duracion (horas)

## PROMPT

Actúa como un desarrollador Laravel experto y Vue JS. Vamos a construir un CRUD completo para certificados, paso a paso y con buenas prácticas.

Crea una migración para la tabla 'certificados' con los siguientes campos:
   - nombre (string, required)
   - institución (string, required)
   - fecha_inicio (date, required)
   - fecha_conclusion (date, nullable - permitir certificados en curso)
   - duracion (integer, required - en horas)
   - timestamps (created_at, updated_at)
   - softDeletes (deleted_at para soft delete)

Incluye también:
   - Validación de que fecha_conclusion sea posterior o igual a fecha_inicio (cuando exista)

## TITULOS

crea una migracion para la tabla 'titulos' con los siguientes campos:
   - nombre (string, required)
   - institucion (string, required)
   - fecha_titulacion (date, required)
   - timestamps (created_at, updated_at)
   - softDeletes (deleted_at para soft delete)

### EXPERIENCIA LABORAL

crea una migracion para la tabla 'experiencias_laborales' con los siguientes campos realizar la migracion y tambien realizar el crud completo igual que el de los titulos usando el panel de administracion, tiene que tener paginacion y el buscador usar policy tambien
   - user_id
   - entidad (string, required)
   - puesto (string, required)
   - descripcion (text required) 'breve descripcion de sus funciones'
   - direccion (string, required)
   - fecha_inicio (date, required)
   - fecha_final (date)
   - duracion 'calcular la duracion con la fecha_inicio y fecha_final si fecha_final no tiene dato dejar vacio'
   - timestamps (created_at, updated_at)
   - softDeletes (deleted_at para soft delete)