# estacionservicio
IFTS21 - Taller 3 - Gestión de estaciones de servicio

¿Cómo bajar este proyecto en GIT a tu XAMPP?
1. Descargar GIT: https://git-scm.com/downloads
2. Instalar GIT. Dar siguiente a todo, excepto en "Adjusting your PATH environment" -> seleccionar la última opción).
3. Abrir Git Bash.
4. Escribir y luego enter: cd /c/xampp/htdocs
5. Escribir y luego enter: git clone https://github.com/Matias1194/estacionservicio.git

---------------------------

Comandos:

• pwd			Muestra la ruta actual.

• cd 			Para entrar en una carpeta en la ruta.

• ls 			Lista los archivos en la carpeta.

• git init		Para inicializar un proyecto nuevo.

• git add 		Para agregar un archivo al staging area.
    ejemplos:
	    git add index.html
	    git add .   (todos)

• git commit	Para crear una versión del archivo.
  ejemplos:
	  git commit 	"Mi primer commit" (luego ENTER, luego :wq)

• git commit -m Para crear una versión del archivo y comentario.
	ejemplos:
    git commit -m "Mi segundo commit"

• git config	Para configurar el nombre e email de quien interactua.
	ejemplos:
    git config --global user.email "matiasmontiel94@hotmail.com"
	  git config --global user.name "Matías"

• git log 		Para ver todos los commits que hemos hecho.

• git checkout 	Para revertir los cambios de los archivos.
	ejemplos:
    git checkout-- index.html

• git diff 		Para ver las diferencias hechas entre archivos.
	ejemplos:
    git diff index.html

• git branch	Para listar las ramas del proyecto.
	ejemplos:
    git branch login

• git checkout 	Para seleccionar otra rama en el proyecto.
	ejemplos:
    git checkout login

• rm -rf .git 	Para borrar el repositorio.

Nota: Cómo ignorar carpetas y/o archivos, para que no se versionen.

1. Crear un archivo llamado .gitignore (texto plano).
2. Dentro del archivo escribir los nombres de los archivos.
3. Agregar el archivo .gitignore (git add .gitignore).


Fuente: https://www.youtube.com/watch?v=HiXLkL42tMU
