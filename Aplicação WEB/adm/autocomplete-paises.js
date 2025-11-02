
function setupAutocomplete(inputElementId, listContainerId, hiddenIdElementId, phpEndpoint) {
    const inputElement = document.getElementById(inputElementId);
    const listContainer = document.getElementById(listContainerId);
    const hiddenIdElement = document.getElementById(hiddenIdElementId);

    let searchTimeout;
    let currentFocus = -1;

    inputElement.addEventListener("input", function(e) {
        const val = this.value;

        clearTimeout(searchTimeout);

        if (!val) {
            hiddenIdElement.value = "";
            closeAllLists();
            return false;
        }

        searchTimeout = setTimeout(() => {
            fetchData(val);
        }, 300);
    });

    function fetchData(searchText) {
        const url = `${phpEndpoint}?term=${encodeURIComponent(searchText)}`;

        fetch(url)
            .then(response => {
                if (!response.ok) {
                    throw new Error(`Erro na requisição: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                displaySuggestions(data, searchText);
            })
            .catch(error => {
                console.error("Erro ao buscar dados:", error);
                closeAllLists();
            });
    }

    function displaySuggestions(arr, val) {
        let i, item;

        closeAllLists();
        currentFocus = -1;

        for (i = 0; i < arr.length; i++) {
            const nome = arr[i].nome;
            const id = arr[i].id;

            item = document.createElement("DIV");

            const index = nome.toUpperCase().indexOf(val.toUpperCase());
            if (index > -1) {
                item.innerHTML = nome.substr(0, index) +
                    "<strong>" + nome.substr(index, val.length) + "</strong>" +
                    nome.substr(index + val.length);
            } else {
                item.innerHTML = nome;
            }

            item.innerHTML += `<input type='hidden' data-id='${id}' value='${nome}'>`;

            item.addEventListener("click", function(e) {
                const selectedInput = this.getElementsByTagName("input")[0];
                
                inputElement.value = selectedInput.value;
                
                hiddenIdElement.value = selectedInput.getAttribute('data-id');
                
                closeAllLists();
            });

            listContainer.appendChild(item);
        }

        if (arr.length > 0) {
            listContainer.style.display = "block";
        } else {
            listContainer.style.display = "none";
        }
    }

    inputElement.addEventListener("keydown", function(e) {
        let x = listContainer.getElementsByTagName("div");
        if (e.keyCode == 40) { // Seta para baixo
            currentFocus++;
            addActive(x);
        } else if (e.keyCode == 38) { // Seta para cima
            currentFocus--;
            addActive(x);
        } else if (e.keyCode == 13) { // Enter
            e.preventDefault();
            if (currentFocus > -1) {
                if (x && x[currentFocus]) x[currentFocus].click();
            }
        }
    });

    function addActive(x) {
        if (!x) return false;
        removeActive(x);
        if (currentFocus >= x.length) currentFocus = 0;
        if (currentFocus < 0) currentFocus = (x.length - 1);
        x[currentFocus].classList.add("autocomplete-active");
    }

    function removeActive(x) {
        for (let i = 0; i < x.length; i++) {
            x[i].classList.remove("autocomplete-active");
        }
    }

    function closeAllLists(elmnt) {
        const x = document.getElementsByClassName("autocomplete-items");
        for (let i = 0; i < x.length; i++) {
            // Verifica se o elemento atual é o container da lista que estamos configurando
            if (x[i].id === listContainerId) {
                if (elmnt != x[i] && elmnt != inputElement) {
                    x[i].innerHTML = ""; // Limpa o conteúdo
                    x[i].style.display = "none"; // Oculta o container
                }
            }
        }
    }

    // Fecha a lista quando o usuário clica em qualquer lugar fora do campo
    document.addEventListener("click", function (e) {
        // Garante que o clique não foi no input ou no container da lista
        if (e.target.id !== inputElementId && e.target.id !== listContainerId) {
            closeAllLists(e.target);
        }
    });
}

// 5. Inicialização para os dois campos (Cadastro e Edição)
document.addEventListener('DOMContentLoaded', (event) => {
    // Autocomplete para o Modal de Cadastro
    setupAutocomplete(
        "cidade-pais-input",    // ID do input de texto
        "cidade-pais-list",     // ID do container da lista
        "cidade-pais-id",       // ID do input hidden para o ID do País
        "autocomplete-paises.php" // Endpoint PHP (vamos criar na próxima fase)
    );

    // Autocomplete para o Modal de Edição
    setupAutocomplete(
        "editar-pais-input",    // ID do input de texto
        "editar-pais-list",     // ID do container da lista
        "editar-pais-id",       // ID do input hidden para o ID do País
        "autocomplete-paises.php" // Endpoint PHP
    );
});
