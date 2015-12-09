@echo off
title VIRUS DE ACCESOS DIRECTOS
color 0A
@echo ----------------------------------------------
@echo REPARACION DE ARCHIVOS USB 
@echo ----------------------------------------------
@echo Mostrando Carpetas
Attrib /d /s -r -h -s *.* 
@echo ----------------------------------------------
@echo Eliminado Accesos Directos
if exist *.lnk del *.lnk 
@echo ----------------------------------------------
@echo Eliminado Autorun
if exist autorun.inf del autorun.inf 
@echo ----------------------------------------------
@echo Eliminado VIRUS RESTORE...
if exist RESTORE rd /s /q RESTORE
@echo ----------------------------------------------
@echo Eliminado VIRUS extension .VBS...
if exist *.vbs del *.vbs
@echo ----------------------------------------------
@echo YA SE TERMINO...
@echo ----------------------------------------------
@echo ----------------------------------------------
@echo Por REDES&TECNOLOGIA AS
@echo ----------------------------------------------
@echo ----------------------------------------------
@echo SALE AS
echo --Software by RedesyTecnologia.AS--------------
@echo ---------      Cel: 04168706812         ------
@echo --------- redesytecnologia.as@gmail.com-------
@echo ----------------------------------------------
@echo Operacion Completa!!!
pause