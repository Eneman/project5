function Promote(id)
{
    $.getJSON("/admin/promote/" + id, data =>
    {
        switch (data.role)
        {
            case ('ROLE_ADMIN'):
                $("#role_" + id).text("Administrateur");
                break;
            case ('ROLE_ORGA'):
                $("#role_" + id).text("Organisateur");
                break;
            case ('ROLE_USER'):
                $("#role_" + id).text("Utilisateur");
                break;
            default:
                $("#role_" + id).text("Pas de Rôle");
                break;
        }
    });
}

function Demote(id)
{
    $.getJSON("/admin/demote/" + id, data =>
    {
        switch (data.role)
        {
            case ('ROLE_ADMIN'):
                $("#role_" + id).text("Administrateur");
                break;
            case ('ROLE_ORGA'):
                $("#role_" + id).text("Organisateur");
                break;
            case ('ROLE_USER'):
                $("#role_" + id).text("Utilisateur");
                break;
            default:
                $("#role_" + id).text("Pas de Rôle");
                break;
        }
    });
}

