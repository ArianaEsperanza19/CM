# Comandos SQL para la base de datos AsistenteSeguros

Primeramente, ir a inicio y buscar _cmd_ o _Símbolo del sistema_ para abrir la terminal.
Debería aparecer una ventana de comandos negra o azul. Para exportar e importar, respectivamente, ingrese los siguientes comandos y presione _enter_.

## Exportar información

**Inglés**

```sql
mysqldump -u root -p AsistenteSeguros > "C:\Users\Usuario\Downloads\datos.sql"
```

**Español**

```sql
mysqldump -u root -p AsistenteSeguros > "C:\Usuarios\Usuario\Descargas\datos.sql"
```

## Importar información

**Inglés**

```sql
mysql -u root -p AsistenteSeguros < "C:\Users\Usuario\Downloads\datos.sql"
```

**Español**

```sql
mysql -u root -p AsistenteSeguros < "C:\Usuarios\Usuario\Descargas\datos.sql"
```

# NOTAS

- Sustituir 'Usuario' por el nombre de tu usuario en el sistema.
- Selecciona la versión en ingles o español, dependiendo del idioma de tu sistema.
