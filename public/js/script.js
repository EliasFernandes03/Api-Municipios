let currentPage = 1; 
const perPage = 15;

document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('ufForm');
    const ufInput = document.getElementById('ufInput');
    const errorMsg = document.getElementById('errorMsg');
    const resultsDiv = document.getElementById('results');

    resultsDiv.addEventListener('click', (e) => {
        if (e.target.id === 'prevPage' && currentPage > 1) {
            currentPage--;
            fetchCities(ufInput.value.trim().toUpperCase(), currentPage, perPage);
        } else if (e.target.id === 'nextPage' && currentPage < (resultsDiv.dataset.lastPage || 1)) {
            currentPage++;
            fetchCities(ufInput.value.trim().toUpperCase(), currentPage, perPage);
        }
    });

    form.addEventListener('submit', async (e) => {
        e.preventDefault();
        errorMsg.style.display = 'none';
        resultsDiv.innerHTML = '';
        currentPage = 1; 
        fetchCities(ufInput.value.trim().toUpperCase(), currentPage, perPage);
    });

    async function fetchCities(uf, page, perPage) {
        try {
            const url = `/api/cities?uf=${uf}&page=${page}&per_page=${perPage}`;
            console.log('Fetching URL:', url); 
            const res = await fetch(url);
            if (!res.ok) {
                const errorData = await res.json();
                if (errorData.errors && errorData.errors.length > 0) {
                    errorMsg.textContent = errorData.errors.map(e => e.detail).join(', ');
                } else {
                    errorMsg.textContent = errorData.message || 'Erro desconhecido';
                }
                errorMsg.style.display = 'block';
                return;
            }

            const data = await res.json();
            renderResults(data);
        } catch (error) {
            errorMsg.textContent = 'Erro ao conectar com o servidor.';
            errorMsg.style.display = 'block';
        }
    }

    function renderResults(data) {
        if (!data.success) {
            errorMsg.textContent = data.message || 'Erro desconhecido';
            errorMsg.style.display = 'block';
            return;
        }

        if (!data.data || data.data.length === 0) {
            resultsDiv.innerHTML = '<p>Nenhum município encontrado.</p>';
            return;
        }

        let html = `
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nome</th>
                    </tr>
                </thead>
                <tbody>
        `;

        data.data.forEach(municipio => {
            html += `<tr><td>${municipio.codigo_ibge || ''}</td><td>${municipio.nome}</td></tr>`;
        });

        html += '</tbody></table>';

        currentPage = data.meta.page || 1;
        const lastPage = data.meta.last_page || 1;

        resultsDiv.dataset.lastPage = lastPage;

        html += `
            <nav>
              <ul class="pagination justify-content-center">
                <li class="page-item ${currentPage === 1 ? 'disabled' : ''}">
                  <button class="page-link" id="prevPage" ${currentPage === 1 ? 'disabled' : ''}>Anterior</button>
                </li>
                <li class="page-item disabled">
                  <span class="page-link">Página ${currentPage} de ${lastPage}</span>
                </li>
                <li class="page-item ${currentPage === lastPage ? 'disabled' : ''}">
                  <button class="page-link" id="nextPage" ${currentPage === lastPage ? 'disabled' : ''}>Próximo</button>
                </li>
              </ul>
            </nav>
        `;

        resultsDiv.innerHTML = html;
    }
});