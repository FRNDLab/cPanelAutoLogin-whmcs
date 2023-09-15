# cPanelAutoLogin-whmcs
Cuando activamos Cloudflare en un servidor cPanel y llamamos a la api <b>/json-api/create_user_session</b>, cPanel devuelve el link para crear la sesión, pero en lugar del hostname, el link redirige a la dirección IP, este módulo corrige este comportamiento.
Funciona con <a href="https://www.modulesgarden.com/products/whmcs/cpanel-extended" target="_blank">cPanel Extended For WHMCS</a> & <a href="https://docs.whmcs.com/CPanel/WHM" target="_blank">WHMCS CPanel/WHM</a>.

# Suba el modulo a <b>/public_html/modules/addons/</b>, activelo.
En la carpeta de su tema activo, busque el archivo <b>clientareaproductdetails.tpl</b>

Despues de:
<pre><code>{$moduleclientarea}</code></pre>

Agregue:
<pre><code>{$cPanelAutoLogin}</code></pre>

Deberia verse asi:<br/>

![Screenshot 2023-09-13 055811](https://github.com/mariofernandu/cPanelAutoLogin-whmcs/assets/102629955/4305927c-141e-40ee-b170-0f81d9439906)

En el caso de <a href="https://lagom.rsstudio.net/" target="_blank">Lagom Theme</a>, este seria el resultado:

![image](https://github.com/mariofernandu/cPanelAutoLogin-whmcs/assets/102629955/a3688acd-d3a6-4b3f-97b4-071bf36ab1aa)


