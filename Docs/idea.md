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