@echo off
title VIRUS DE ACCESOS DIRECTOS
color 1E
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
@echo YA SE TERMINO...
@echo ----------------------------------------------
@echo ----------------------------------------------
@echo Por REDES&TECNOLOGIA AS
@echo ----------------------------------------------
@echo ----------------------------------------------
@echo SALE REDES&TECNOLOGIA AS