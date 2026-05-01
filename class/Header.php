<?php
//Array simulando una tabla de la base de datos, en lo que se crea la tabla real

$header = [
    ["pkheader" => 1, "sucursal" => 1, "control" => 6, "texto1" => "Formulario - Sistema de Gestión de Calidad / Villahermosa / Tabasco",
    "texto2" => "Cotización","texto3" => "MSP-50-40-01 Rev. Orig.", "texto4" => "", "titulodesc" => "HENRRY HERNANDEZ PEREZ",
    "descripcion" => "CALLE OCHO, LT-1-C MZA-III, FRACCIONAMIENTO DEIT,<br>
 RIA. ANACLETO CANABAL 1RA. SECC.<br>
 CENTRO, TABASCO, CP. 86287<br>
 TEL: (993) 337 9968", "correo" => "ventas01@mspetroleros.com", "revision" => "", 
 "footer" => "Maquinados y Servicios Petroleros, Metal mecánica lntegral, Certificación API en cada pieza, 
                    Calidad en cada proceso y la puntualidad que su proyecto exige.<br>
                    <strong>Certificada por AMERICAN PETROLEUM INSTITUTE -API</strong><br>
                    Bajo los números de licencias: Q1_4727, 7-1_1667, 6A_2513"],

    ["pkheader" => 2, "sucursal" => 1, "control" => 7, "texto1" => "Formulario - Sistema de Gestión de Calidad / Villahermosa / Tabasco",
    "texto2" => "Orden de Trabajo","texto3" => "MSP-30-40-03 Rev. Orig.", "texto4" => "", "titulodesc" => "HENRRY HERNANDEZ PEREZ",
    "descripcion" => "CALLE OCHO, LT-1-C MZA-III, FRACCIONAMIENTO DEIT,<br>
 RIA. ANACLETO CANABAL 1RA. SECC.<br>
 CENTRO, TABASCO, CP. 86287<br>
 TEL: (993) 337 9968", "correo" => "ventas01@mspetroleros.com", "revision" => ""],

 ["pkheader" => 3, "sucursal" => 1, "control" => 8, "texto1" => "Formulario - Sistema de Gestión de Calidad / Villahermosa / Tabasco",
    "texto2" => "Entrega de Servicios / Materiales / Productos","texto3" => "MSP-50-40-07 Rev. Orig.", "texto4" => "", "titulodesc" => "HENRRY HERNANDEZ PEREZ",
    "descripcion" => "CALLE OCHO, LT-1-C MZA-III, FRACCIONAMIENTO DEIT,<br>
 RIA. ANACLETO CANABAL 1RA. SECC.<br>
 CENTRO, TABASCO, CP. 86287<br>
 TEL: (993) 337 9968", "correo" => "ventas01@mspetroleros.com", "revision" => ""],

 ["pkheader" => 4, "sucursal" => 1, "control" => 14, "texto1" => "",
 "texto2" => "","texto3" => "MSP-40-40-02", "texto4" => "", "titulodesc" => "HENRRY HERNANDEZ PEREZ",
 "descripcion" => "CALLE OCHO, LT-1-C MZA-III, FRACCIONAMIENTO DEIT,<br>
 RIA. ANACLETO CANABAL 1RA. SECC.<br>
 CENTRO, TABASCO, CP. 86287<br>
 TEL: (993) 337 9968", "correo" => "ventas01@mspetroleros.com", "revision" => "Rev. 1", "nota" => "POR AUSENCIA DEL GERENTE GRAL. PUEDE FIRMAR GERENTE OPERATIVO"],

 ["pkheader" => 5, "sucursal" => 1, "control" => 15, "texto1" => "",
 "texto2" => "","texto3" => "MSP-40-40-03", "texto4" => "", "titulodesc" => "HENRRY HERNANDEZ PEREZ",
 "descripcion" => "CALLE OCHO, LT-1-C MZA-III, FRACCIONAMIENTO DEIT,<br>
 RIA. ANACLETO CANABAL 1RA. SECC.<br>
 CENTRO, TABASCO, CP. 86287<br>
 TEL: (993) 337 9968", "correo" => "ventas01@mspetroleros.com", "revision" => "Rev. 1", "nota" => "POR AUSENCIA DEL GERENTE GRAL. PUEDE FIRMAR GERENTE OPERATIVO"],

   //SUCURSAL 2 BASE BELISARIO

 ["pkheader" => 6, "sucursal" => 2, "control" => 6, "texto1" => " Formulario - Sistema de Gestión de Calidad / Cd. del Carmen / Campeche",
 "texto2" => "Cotización","texto3" => "MSP-50-40-01 Rev. 1", "texto4" => "BELISARIO", "titulodesc" => "HENRRY HERNANDEZ PEREZ",
 "descripcion" => "Calle Campeche No.9 por Quintana Roo y Chiapas,<br>
  Col. Belisario Domínguez<br>
  C.P. 24150, Cd. del Carmen, Campeche.<br>
   TEL: 938011809032", "correo" => "ventas02@mspetroleros.com", "revision" => "",
  "footer" => "<div style=\"font-style:italic;text-align:left;font-family:'Times New Roman'\">Maquinados y Servicios Petroleros, Metal mecánica lntegral, Certificación API en cada pieza, 
   Calidad en cada proceso y la puntualidad que su proyecto exige.</div>\""],

   ["pkheader" => 7, "sucursal" => 2, "control" => 7, "texto1" => " Formulario - Sistema de Gestión de Calidad / Cd. del Carmen / Campeche",
 "texto2" => "Orden de Trabajo","texto3" => "MSP-30-40-03 Rev. 1", "texto4" => "BELISARIO", "titulodesc" => "HENRRY HERNANDEZ PEREZ",
 "descripcion" => "Calle Campeche No.9 por Quintana Roo y Chiapas,<br>
  Col. Belisario Domínguez<br>
  C.P. 24150, Cd. del Carmen, Campeche.<br>
   TEL: 938011809032", "correo" => "ventas02@mspetroleros.com", "revision" => ""],

   ["pkheader" => 8, "sucursal" => 2, "control" => 8, "texto1" => " Formulario - Sistema de Gestión de Calidad / Cd. del Carmen / Campeche",
   "texto2" => "Entrega de Servicios / Materiales / Productos","texto3" => "MSP-50-40-07 Rev. 1", "texto4" => "BELISARIO", "titulodesc" => "HENRRY HERNANDEZ PEREZ",
   "descripcion" => "Calle Campeche No.9 por Quintana Roo y Chiapas,<br>
   Col. Belisario Domínguez<br>
   C.P. 24150, Cd. del Carmen, Campeche.<br>
   TEL: 938011809032", "correo" => "ventas02@mspetroleros.com", "revision" => ""],

   ["pkheader" => 9, "sucursal" => 2, "control" => 14, "texto1" => "",
 "texto2" => "","texto3" => "MSP-40-40-02", "texto4" => "BELISARIO", "titulodesc" => "HENRRY HERNANDEZ PEREZ",
 "descripcion" => "Calle Campeche No.9 por Quintana Roo y Chiapas,<br>
   Col. Belisario Domínguez<br>
   C.P. 24150, Cd. del Carmen, Campeche.<br>
   TEL: 938011809032", "correo" => "ventas02@mspetroleros.com", "revision" => "Rev. Orig.", "nota" => "POR AUSENCIA DEL GERENTE GRAL. PUEDE FIRMAR JEFE DE PRODUCCION"],

 ["pkheader" => 10, "sucursal" => 2, "control" => 15, "texto1" => "",
 "texto2" => "","texto3" => "MSP-40-40-03", "texto4" => "BELISARIO", "titulodesc" => "HENRRY HERNANDEZ PEREZ",
 "descripcion" => "Calle Campeche No.9 por Quintana Roo y Chiapas,<br>
   Col. Belisario Domínguez<br>
   C.P. 24150, Cd. del Carmen, Campeche.<br>
   TEL: 938011809032", "correo" => "ventas02@mspetroleros.com", "revision" => "Rev. 1", "nota" => "POR AUSENCIA DEL GERENTE GRAL. PUEDE FIRMAR JEFE DE PRODUCCION"],

   //SUCURSAL 3 BASE 49

   ["pkheader" => 11, "sucursal" => 3, "control" => 6, "texto1" => "Formulario - Sistema de Gestión de Calidad / Cd. del Carmen / Campeche",
   "texto2" => "Cotización","texto3" => "MSP-50-40-01 Rev. 1", "texto4" => "BASE 49", "titulodesc" => "HENRRY HERNANDEZ PEREZ",
   "descripcion" => "Calle Campeche No.9 por Quintana Roo y Chiapas,<br>
    Col. Belisario Domínguez<br>
    C.P. 24150, Cd. del Carmen, Campeche.<br>
     TEL: 938011809032", "correo" => "ventas02@mspetroleros.com", "revision" => "",
     "footer" => "<div style=\"font-style:italic;text-align:left;font-family:'Times New Roman'\">Maquinados y Servicios Petroleros, Metal mecánica lntegral, Certificación API en cada pieza, 
      Calidad en cada proceso y la puntualidad que su proyecto exige.</div>\""],
  
     ["pkheader" => 12, "sucursal" => 3, "control" => 7, "texto1" => "Formulario - Sistema de Gestión de Calidad / Cd. del Carmen / Campeche",
   "texto2" => "Orden de Trabajo","texto3" => "MSP-30-40-03 Rev. 1", "texto4" => "BASE 49", "titulodesc" => "HENRRY HERNANDEZ PEREZ",
   "descripcion" => "Calle Campeche No.9 por Quintana Roo y Chiapas,<br>
    Col. Belisario Domínguez<br>
    C.P. 24150, Cd. del Carmen, Campeche.<br>
     TEL: 938011809032", "correo" => "ventas02@mspetroleros.com", "revision" => ""],
  
     ["pkheader" => 13, "sucursal" => 3, "control" => 8, "texto1" => "Formulario - Sistema de Gestión de Calidad / Cd. del Carmen / Campeche",
     "texto2" => "Entrega de Servicios / Materiales / Productos","texto3" => "MSP-50-40-07 Rev. 1", "texto4" => "BASE 49", "titulodesc" => "HENRRY HERNANDEZ PEREZ",
     "descripcion" => "Calle Campeche No.9 por Quintana Roo y Chiapas,<br>
     Col. Belisario Domínguez<br>
     C.P. 24150, Cd. del Carmen, Campeche.<br>
     TEL: 938011809032", "correo" => "ventas02@mspetroleros.com", "revision" => ""],
  
     ["pkheader" => 14, "sucursal" => 3, "control" => 14, "texto1" => "",
   "texto2" => "","texto3" => "MSP-40-40-02", "texto4" => "BASE 49", "titulodesc" => "HENRRY HERNANDEZ PEREZ",
   "descripcion" => "Calle Campeche No.9 por Quintana Roo y Chiapas,<br>
     Col. Belisario Domínguez<br>
     C.P. 24150, Cd. del Carmen, Campeche.<br>
     TEL: 938011809032", "correo" => "ventas02@mspetroleros.com", "revision" => "Rev. Orig.", "nota" => "POR AUSENCIA DEL GERENTE GRAL. PUEDE FIRMAR JEFE DE PRODUCCION"],
  
   ["pkheader" => 15, "sucursal" => 3, "control" => 15, "texto1" => "",
   "texto2" => "","texto3" => "MSP-40-40-03", "texto4" => "BASE 49", "titulodesc" => "HENRRY HERNANDEZ PEREZ",
   "descripcion" => "Calle Campeche No.9 por Quintana Roo y Chiapas,<br>
     Col. Belisario Domínguez<br>
     C.P. 24150, Cd. del Carmen, Campeche.<br>
     TEL: 938011809032", "correo" => "ventas02@mspetroleros.com", "revision" => "Rev. 1", "nota" => "POR AUSENCIA DEL GERENTE GRAL. PUEDE FIRMAR JEFE DE PRODUCCION"],

     ["pkheader" => 16, "sucursal" => 1, "control" => 5, "texto1" => "Formulario - Sistema de Gestión de Calidad / Villahermosa / Tabasco",
    "texto2" => "Revisión Preliminar del Contrato","texto3" => "MSP-50-40-02 Rev. Orig.", "texto4" => "", "titulodesc" => "",
    "descripcion" => "", "correo" => "", "revision" => ""],

    ["pkheader" => 17, "sucursal" => 2, "control" => 5, "texto1" => "Formulario - Sistema de Gestión de Calidad / Cd. del Carmen / Campeche",
    "texto2" => "Revisión Preliminar del Contrato","texto3" => "MSP-50-40-02 Rev. 2", "texto4" => "BELISARIO", "titulodesc" => "",
    "descripcion" => "", "correo" => "", "revision" => ""],

    ["pkheader" => 18, "sucursal" => 3, "control" => 5, "texto1" => "Formulario - Sistema de Gestión de Calidad / Cd. del Carmen / Campeche",
    "texto2" => "Revisión Preliminar del Contrato","texto3" => "MSP-50-40-02 Rev. 2", "texto4" => "BASE 49", "titulodesc" => "",
    "descripcion" => "", "correo" => "", "revision" => ""],
];