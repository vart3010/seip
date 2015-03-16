Se agrego menu nuevo de los programas de gestion en el admin.
Se agrego eliminacion logica a los programas de gestion y sus items.

Se implemento acl:
app/console init:acl
app/console sonata:admin:setup-acl --env=prod
php -d memory_limit=-1 app/console sonata:admin:generate-object-acl --env=prod

Se agreo nuevas entidades al administrador (Gerencia, Gerencia de segunda, Grupo de gerencia, Complejo).