# estacionservicio
IFTS21 - Taller 3 - Gestión de estaciones de servicio

¿Cómo bajar este proyecto en GIT a tu XAMPP? (Antes que nada, eliminá la carpeta "estacionservicio").
1. Descargá GIT: https://git-scm.com/downloads
2. Instalá GIT. Dar siguiente a todo, excepto en "Adjusting your PATH environment" -> seleccionar la última opción).
3. Abrí Git Bash.
4. Escribí en la consola y luego enter: cd /c/xampp/htdocs
5. Escribí en la consola y luego enter: git clone https://github.com/Matias1194/estacionservicio.git

- ¿Y qué más?
- Nada más, ya podés abrir tu carpeta local del xampp (c/xampp/htdocs/estacionservicio) en tu Sublime Text.

Los cambios que hagas, ya sean editar/agregar/borrar archivos o carpetas, tienen que impactar en el repositorio GIT para que el proyecto se mantenga actualizado, para eso es necesario usar Git Bash y conocer algunos comandos como: CONFIG, ADD, COMMIT, STATUS, PULL, LOG.

> Es importante que los comandos que escribas sean estando en el directorio que apunte a la carpeta del proyecto (para saber en qué carpeta estás, tipeá este comando: pwd). Si no estás en la carpeta "estacionservicio" tendrás que tipear: cd /c/xampp/htdocs/estacionservicio

- Listo, ya estoy parado sobre el directorio de mi proyecto ¿Cómo empiezo?
- Primero te recomiendo que te identifiques con tu nombre (esto ayuda para saber quién realizó cambios en el repositorio) utilizando este comando: git config --global user.name "TuNombre"

- Perfecto, recién creé un nuevo archivo llamado "inicio.php", ¿Cómo lo subo al repositorio?
- Este archivo es nuevo y no lo reconoce el repositorio, hay que usar el comando ADD para confirmar que este archivo se va a commitear. Y luego usar el comando COMMIT para subir el archivo.
En la consola Git Bash vas a escribir: git add inicio.php  y luego: git commit -m "Algún comentario al respecto"

- Aah, primero agregar los cambios y luego commitearlo, claro. ¿Funciona igual para cuando modifique un archivo ya existente?
- Exactamente, idéntico al caso anterior.

- Entiendo, y ¿cómo sé qué si edité archivos y no me di cuenta de subirlos al repositorio?
- Con este comando vas a saber si editaste archivos y no los subiste: git status

- Buenísimo, ahora me faltaría obtener los últimos cambios que se hicieron en el repositorio, ¿Se puede?
- Si, para actualizar el proyecto hay que utilizar este comando: git pull

- Genial, ¿y si quiero ver los últimos commits que se hicieron?
- Para eso vas a usar este comando: git log

- Alto nerd...

---------------------------

Comandos para GIT Bash:

• pwd			Muestra la ruta del directorio actual.

• cd 			Para navegar entre las carpetas del directorio.

• ls 			Lista los archivos que hay en la carpeta actual.

• git init		Para inicializar un proyecto nuevo.

• git add 		Para agregar un archivo al staging area.
    ejemplos:
	    git add inicio.php
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
    git checkout-- inicio.php

• git diff 		Para ver las diferencias hechas entre archivos.
	ejemplos:
    git diff inicio.php

• git branch	Para listar las ramas del proyecto.
	ejemplos:
    git branch login

• git checkout 	Para seleccionar otra rama en el proyecto.
	ejemplos:
    git checkout login

• rm -rf .git 	Para borrar el repositorio.

---------------------------

Nota: Cómo ignorar carpetas y/o archivos para que no se versionen en el repositorio al commitear.

1. Crear un archivo llamado .gitignore (texto plano).
2. Dentro del archivo escribir los nombres de los archivos (uno debajo del otro separados con enter).
3. Agregar el archivo .gitignore al repositorio por medio de GIT Bash: git add .gitignore.


Fuente: https://www.youtube.com/watch?v=HiXLkL42tMU