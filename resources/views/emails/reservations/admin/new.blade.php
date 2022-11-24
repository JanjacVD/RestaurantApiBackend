<body>
    <h1>Nova Rezervacije</h1>
    <table style="font-size: 1.4rem">
        <tr>
            <td>
                Ime:
            </td>
            <td>
                {{$guest->name}}
            </td>
        </tr>
        <tr>
            <td>
                Mobitel:
            </td>
            <td>
                {{$guest->phone}}
            </td>
        </tr>
        <tr>
            <td>
                Broj osoba:
            </td>
            <td>
                {{$guest->numOfPeople}}
            </td>
        </tr>
        <tr>
            <td>
                Vrijeme:
            </td>
            <td>
                {{$guest->reservation_datetime}}
            </td>
        </tr>
    </table>
</body>