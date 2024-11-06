<!-- Modal Formulário -->
<div class="modal fade" id="{{ $modal_id }}" tabindex="-1" aria-labelledby="formRelatorioModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="formRelatorioModalLabel">Gerar Relatório</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form action="{{ route('downloadPDF') }}" method="get">
          @csrf
          <input type="hidden" name="list_id" value="{{ $list_id }}">
          <div class="modal-body">
            <div class="mb-3">
              <label for="client_name" class="form-label">Nome do Cliente</label>
              <input type="text" class="form-control" id="nome_cliente" name="client_name" required>
            </div>
            <div class="mb-3">
              <label for="project_description" class="form-label">Descrição do Projeto</label>
              <textarea class="form-control" id="descricao_projeto" name="project_description" rows="12" required></textarea>
            </div>
            <!-- Outros campos podem ser adicionados aqui -->
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
            <button type="submit" class="btn btn-success">Gerar Relatório</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  