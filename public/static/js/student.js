
/*document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('citizenForm');
    const toggleSwitch = document.getElementById('toggleSwitch');
    const deleteBtn = document.getElementById('deleteBtn');
    const baseURL = 'http://127.0.0.1:5000';

    form.addEventListener('submit', function(event) {
        event.preventDefault();
        const formData = new FormData(form);
        const data = Object.fromEntries(formData.entries());
        postData(baseURL + '/add_citizen', data)
            .then(response => console.log(response))
            .catch(error => console.error('Error:', error));
    });

    deleteBtn.addEventListener('click', function() {
        const name  = prompt("Enter the  Name  of the citizen to delete:");
        if (name) {
            deleteCitizen(name);
        }
    });

    toggleSwitch.addEventListener('change', function() {
        const theme = toggleSwitch.checked ? 'dark' : 'light';
        document.body.setAttribute('data-theme', theme);
        localStorage.setItem('theme', theme);
    });

    // Check local storage for theme preference
    const savedTheme = localStorage.getItem('theme');
    if (savedTheme) {
        document.body.setAttribute('data-theme', savedTheme);
        if (savedTheme === 'dark') {
            toggleSwitch.checked = true;
        }
    }

    async function deleteCitizen(name) {
        const response = await fetch(baseURL + '/delete_citizen', {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ name:name })
        });
        const data = await response.json();
        console.log(data);
    }

    async function postData(url = '', data = {}) {
        const response = await fetch(url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(data)
        });
        const responseData = await response.json();
        return responseData
    }
});
const selectPays = document.getElementById("pays");
const countries = [
    { code: "AF", name: "Afghanistan" },
    { code: "AL", name: "Albanie" },
    {code: "DZ", name: "Algérie"},
    {code: "DE", name: "Allemagne"},
    {code: "AD", name: "Andorre"},
    {code: "AO", name: "Angola"},
    {code: "AI", name: "Anguilla"},
    {code: "AQ", name: "Antarctique"},
    {code: "AG", name: "Antigua-et-Barbuda"},
    {code: "SA", name: "Arabie saoudite"},
    {code: "AR", name: "Argentine"},
    {code: "AM", name: "Arménie"},
    {code: "AW", name: "Aruba"},
    {code: "AU", name: "Australie"},
    {code: "AT", name: "Autriche"},
    {code: "AZ", name: "Azerbaïdjan"},
    {code: "BS", name: "Bahamas"},
    {code: "BH", name: "Bahreïn"},
    {code: "BD", name: "Bangladesh"},
    {code: "BB", name: "Barbade"},
    {code: "BY", name: "Biélorussie"},
    {code: "BE", name: "Belgique"},
    {code: "BZ", name: "Belize"},
    {code: "BJ", name: "Bénin"},
    {code: "BM", name: "Bermudes"},
    {code: "BT", name: "Bhoutan"},
    {code: "BO", name: "Bolivie"},
    {code: "BA", name: "Bosnie-Herzégovine"},
    {code: "BW", name: "Botswana"},
    {code: "BR", name: "Brésil"},
    {code: "BN", name: "Brunei"},
    {code: "BG", name: "Bulgarie"},
    {code: "BF", name: "Burkina Faso"},
    {code: "BI", name: "Burundi"},
    {code: "KH", name: "Cambodge"},
    {code: "CM", name: "Cameroun"},
    {code: "CA", name: "Canada"},
    {code: "CV", name: "Cap-Vert"},
    {code: "CF", name: "République centrafricaine"},
    {code: "CL", name: "Chili"},
    {code: "CN", name: "Chine"},
    {code: "CY", name: "Chypre"},
    {code: "CO", name: "Colombie"},
    {code: "KM", name: "Comores"},
    {code: "CG", name: "République du Congo"},
    {code: "CD", name: "RD Congo"},
    {code: "CK", name: "Îles Cook"},
    {code: "CR", name: "Costa Rica"},
    {code: "HR", name: "Croatie"},
    {code: "CU", name: "Cuba"},
    {code: "CI", name: "Côte d'Ivoire"},
    {code: "DK", name: "Danemark"},
    {code: "DJ", name: "Djibouti"},
    {code: "DM", name: "Dominique"},
    {code: "EG", name: "Égypte"},
    {code: "SV", name: "Salvador"},
    {code: "AE", name: "Émirats arabes unis"},
    {code: "EC", name: "Équateur"},
    {code: "ER", name: "Érythrée"},
    {code: "ES", name: "Espagne"},
    {code: "EE", name: "Estonie"},
    {code: "US", name: "États-Unis"},
    {code: "ET", name: "Éthiopie"},
    {code: "FJ", name: "Fidji"},
    {code: "FI", name: "Finlande"},
    {code: "FR", name: "France"},
    {code: "GA", name: "Gabon"},
    {code: "GM", name: "Gambie"},
    {code: "GE", name: "Géorgie"},
    {code: "GS", name: "Géorgie du Sud-et-les Îles Sandwich du Sud"},
    {code: "GH", name: "Ghana"},
    {code: "GI", name: "Gibraltar"},
    {code: "GR", name: "Grèce"},
    {code: "GD", name: "Grenade"},
    {code: "GL", name: "Groenland"},
    {code: "GP", name: "Guadeloupe"},
    {code: "GU", name: "Guam"},
    {code: "GT", name: "Guatemala"},
    {code: "GG", name: "Guernesey"},
    {code: "GN", name: "Guinée"},
    {code: "GW", name: "Guinée-Bissau"},
    {code: "GQ", name: "Guinée équatoriale"},
    {code: "GY", name: "Guyana"},
    {code: "GF", name: "Guyane française"},
    {code: "HT", name: "Haïti"},
    {code: "HN", name: "Honduras"},
    {code: "HK", name: "Hong Kong"},
    {code: "HU", name: "Hongrie"},
    {code: "IM", name: "Île de Man"},
    {code: "UM", name: "Îles mineures éloignées des États-Unis"},
    {code: "VI", name: "Îles Vierges des États-Unis"},
    {code: "VG", name: "Îles Vierges britanniques"},
    {code: "IN", name: "Inde"},
    {code: "ID", name: "Indonésie"},
    {code: "IQ", name: "Irak"},
    {code: "IR", name: "Iran"},
    {code: "IE", name: "Irlande"},
    {code: "IS", name: "Islande"},
    {code: "IL", name: "Israël"},
    {code: "IT", name: "Italie"},
    {code: "JM", name: "Jamaïque"},
    {code: "JP", name: "Japon"},
    {code: "JE", name: "Jersey"},
    {code: "JO", name: "Jordanie"},
    {code: "KZ", name: "Kazakhstan"},
    {code: "KE", name: "Kenya"},
    {code: "KG", name: "Kirghizistan"},
    {code: "KI", name: "Kiribati"},
    {code: "KW", name: "Koweït"},
    {code: "LA", name: "Laos"},
    {code: "LS", name: "Lesotho"},
    {code: "LV", name: "Lettonie"},
    {code: "LB", name: "Liban"},
    {code: "LR", name: "Libéria"},
    {code: "LY", name: "Libye"},
    {code: "LI", name: "Liechtenstein"},
    {code: "LT", name: "Lituanie"},
    {code: "LU", name: "Luxembourg"},
    {code: "MO", name: "Macao"},
    {code: "MK", name: "Macédoine"},
    {code: "MG", name: "Madagascar"},
    {code: "MY", name: "Malaisie"},
    {code: "MW", name: "Malawi"},
    {code: "MV", name: "Maldives"},
    {code: "ML", name: "Mali"},
    {code: "MT", name: "Malte"},
    {code: "MP", name: "Îles Mariannes du Nord"},
    {code: "MA", name: "Maroc"},
    {code: "MH", name: "Îles Marshall"},
    {code: "MQ", name: "Martinique"},
    {code: "MU", name: "Maurice"},
    {code: "MR", name: "Mauritanie"},
    {code: "YT", name: "Mayotte"},
    {code: "YT", name: "Mayotte"},
    {code: "MX", name: "Mexique"},
    {code: "FM", name: "Micronésie"},
    {code: "MD", name: "Moldavie"},
    {code: "MC", name: "Monaco"},
    {code: "MN", name: "Mongolie"},
    {code: "ME", name: "Monténégro"},
    {code: "MS", name: "Montserrat"},
    {code: "MZ", name: "Mozambique"},
    {code: "NA", name: "Namibie"},
    {code: "NR", name: "Nauru"},
    {code: "NP", name: "Népal"},
    {code: "NI", name: "Nicaragua"},
    {code: "NE", name: "Niger"},
    {code: "NG", name: "Nigéria"},
    {code: "NU", name: "Niue"},
    {code: "NF", name: "Île Norfolk"},
    {code: "NO", name: "Norvège"},
    {code: "NC", name: "Nouvelle-Calédonie"},
    {code: "NZ", name: "Nouvelle-Zélande"},
    {code: "OM", name: "Oman"},
    {code: "UG", name: "Ouganda"},
    {code: "UZ", name: "Ouzbékistan"},
    {code: "PK", name: "Pakistan"},
    {code: "PW", name: "Palaos"},
    {code: "PS", name: "Palestine"},
    {code: "PA", name: "Panama"},
    {code: "PG", name: "Papouasie-Nouvelle-Guinée"},
    {code: "PY", name: "Paraguay"},
    {code: "NL", name: "Pays-Bas"},
    {code: "PE", name: "Pérou"},
    {code: "PH", name: "Philippines"},
    {code: "PN", name: "Îles Pitcairn"},
    {code: "PL", name: "Pologne"},
    {code: "PF", name: "Polynésie française"},
    {code: "PR", name: "Porto Rico"},
    {code: "PT", name: "Portugal"},
    {code: "QA", name: "Qatar"},
    {code: "RE", name: "La Réunion"},
    {code: "RO", name: "Roumanie"},
    {code: "GB", name: "Royaume-Uni"},
    {code: "RU", name: "Russie"},
    {code: "RW", name: "Rwanda"},
    {code: "EH", name: "Sahara occidental"},
    {code: "BL", name: "Saint-Barthélemy"},
    {code: "KN", name: "Saint-Christophe-et-Niévès"},
    {code: "SM", name: "Saint-Marin"},
    {code: "MF", name: "Saint-Martin (partie française)"},
    {code: "SX", name: "Saint-Martin (partie néerlandaise)"},
    {code: "PM", name: "Saint-Pierre-et-Miquelon"},
    {code: "VA", name: "Saint-Siège (État de la Cité du Vatican)"},
    {code: "VC", name: "Saint-Vincent-et-les-Grenadines"},
    {code: "SH", name: "Sainte-Hélène, Ascension et Tristan da Cunha"},
    {code: "LC", name: "Sainte-Lucie"},
    {code: "SB", name: "Salomon"},
    {code: "WS", name: "Samoa"},
    {code: "AS", name: "Samoa américaines"},
    {code: "ST", name: "Sao Tomé-et-Principe"},
    {code: "SN", name: "Sénégal"},
    {code: "RS", name: "Serbie"},
    {code: "SC", name: "Seychelles"},
    {code: "SL", name: "Sierra Leone"},
    {code: "SG", name: "Singapour"},
    {code: "SK", name: "Slovaquie"},
    {code: "SI", name: "Slovénie"},
    {code: "SO", name: "Somalie"},
    {code: "SD", name: "Soudan"},
    {code: "SS", name: "Soudan du Sud"},
    {code: "LK", name: "Sri Lanka"},
    {code: "SE", name: "Suède"},
    {code: "CH", name: "Suisse"},
    {code: "SR", name: "Suriname"},
    {code: "SJ", name: "Svalbard et Jan Mayen"},
    {code: "SZ", name: "Swaziland"},
    {code: "SY", name: "Syrie"},
    {code: "TJ", name: "Tadjikistan"},
    {code: "TW", name: "Taïwan"},
    {code: "TZ", name: "Tanzanie"},
    {code: "TD", name: "Tchad"},
    {code: "CZ", name: "République tchèque"},
    {code: "TF", name: "Terres australes et antarctiques françaises"},
    {code: "TH", name: "Thaïlande"},
    {code: "TL", name: "Timor oriental"},
    {code: "TG", name: "Togo"},
    {code: "TK", name: "Tokelau"},
    {code: "TO", name: "Tonga"},
    {code: "TT", name: "Trinité-et-Tobago"},
    {code: "TN", name: "Tunisie"},
    {code: "TM", name: "Turkménistan"},
    {code: "TC", name: "Îles Turques-et-Caïques"},
    {code: "TR", name: "Turquie"},
    {code: "TV", name: "Tuvalu"},
    {code: "UA", name: "Ukraine"},
    {code: "UY", name: "Uruguay"},
    {code: "VU", name: "Vanuatu"},
    {code: "VE", name: "Venezuela"},
    {code: "VN", name: "Viêt Nam"},
    {code: "WF", name: "Wallis-et-Futuna"},
    {code: "YE", name: "Yémen"},
    {code: "ZM", name: "Zambie"},
    {code: "ZW", name: "Zimbabwe"}
];
countries.forEach(country => {
    const option = document.createElement("option");
    option.value = country.code;
    option.text = country.name;
    selectPays.appendChild(option);
});

function showSnackbarSubmit() {
    const snackbar = document.getElementById("snackbar");
    snackbar.classList.add("show");

    // Après 3 secondes, masquez le snackbar
    setTimeout(function() {
        snackbar.classList.remove("show");
    }, 3000);
}

function showSnackbarDelete() {
    const snackbar = document.getElementById("snackbar2");
    snackbar.classList.add("show");

    // Après 3 secondes, masquez le snackbar
    setTimeout(function() {
        snackbar.classList.remove("show");
    }, 3000);
}