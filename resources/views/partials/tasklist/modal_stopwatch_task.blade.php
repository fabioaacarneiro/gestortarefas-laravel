<!-- Modal do Cronômetro -->
<div class="modal fade" id="{{ $modal_id }}" tabindex="-1" aria-labelledby="{{ $modal_id }}Label" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="text-info"><strong>{{ $list_name }}</strong> - <em>{{ $name }}</em></h4>
            </div>
            <div class="p-3 modal-body">
                <div class="d-flex justify-content-center">
                    <p id="timerDisplay_{{ $modal_id }}" class="fs-2">00:00</p> <!-- Exibição do cronômetro -->
                </div>
                <div class="d-flex justify-content-center" role="group" aria-label="Timer Controls">
                    <div class="btn-group">
                        <button id="playButton_{{ $modal_id }}" class="btn btn-success btn-lg"><i class="fas fa-play"></i></button>
                        <button id="pauseButton_{{ $modal_id }}" class="btn btn-warning btn-lg" disabled><i class="fas fa-pause"></i></button>
                        <button id="stopButton_{{ $modal_id }}" class="btn btn-danger btn-lg" disabled><i class="fas fa-stop"></i></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // A lógica agora será carregada apenas quando o modal for mostrado
    document.getElementById('modalTaskChronometer_{{ $task['id'] }}_{{ $list_id }}').addEventListener('show.bs.modal', function () {
        // ID único do modal da tarefa
        const modalTaskId = "{{ $modal_id }}";

        let elapsedDisplay = document.getElementById(`timerDisplay_${modalTaskId}`);
        let runningTaskKey = `runningTaskId_${modalTaskId}`;

        // Botões
        const playButton = document.getElementById(`playButton_${modalTaskId}`);
        const pauseButton = document.getElementById(`pauseButton_${modalTaskId}`);
        const stopButton = document.getElementById(`stopButton_${modalTaskId}`);

        let timer;
        let isRunning = false;
        let elapsedTime = 0;
        let startTime = 0;

        // Recupera o estado do cronômetro ao carregar o modal
        function loadState() {
            const savedTime = localStorage.getItem(`elapsedTime_${modalTaskId}`);
            const savedRunningState = localStorage.getItem(`isRunning_${modalTaskId}`);
            const currentRunningTask = localStorage.getItem(runningTaskKey);

            if (savedTime) {
                elapsedTime = parseInt(savedTime);
                updateDisplay();
            }

            if (savedRunningState === 'true') {
                startTimer();  // Retorna ao estado de execução
            }
        }

        // Função para atualizar o display do cronômetro
        function updateDisplay() {
            const minutes = Math.floor(elapsedTime / 60);
            const seconds = elapsedTime % 60;
            elapsedDisplay.textContent = `${String(minutes).padStart(2, '0')}:${String(seconds).padStart(2, '0')}`;
        }

        // Função para salvar o estado do cronômetro no localStorage
        function saveState() {
            localStorage.setItem(`elapsedTime_${modalTaskId}`, elapsedTime);
            localStorage.setItem(`isRunning_${modalTaskId}`, isRunning);
        }

        // Função para iniciar o cronômetro
        function startTimer() {
            if (!isRunning) {
                const currentRunningTask = localStorage.getItem(runningTaskKey);
                if (currentRunningTask && currentRunningTask !== modalTaskId) {
                    pauseTimer();  // Pausa outro cronômetro se ele estiver rodando
                }

                // Marca este cronômetro como rodando
                localStorage.setItem(runningTaskKey, modalTaskId);

                isRunning = true;
                startTime = Date.now() - elapsedTime * 1000; // Ajusta o tempo inicial
                timer = setInterval(function() {
                    elapsedTime = Math.floor((Date.now() - startTime) / 1000);  // Atualiza o tempo
                    updateDisplay();
                    saveState();
                }, 1000);

                // Atualiza os botões
                playButton.disabled = true;
                pauseButton.disabled = false;
                stopButton.disabled = false;
            }
        }

        // Função para pausar o cronômetro
        function pauseTimer() {
            if (isRunning) {
                clearInterval(timer);
                isRunning = false;
                playButton.disabled = false;
                pauseButton.disabled = true;
                stopButton.disabled = false;
                saveState();
                localStorage.setItem(runningTaskKey, '');  // Remove a tarefa do "running"
            }
        }

        // Função para parar o cronômetro
        function stopTimer() {
            if (isRunning) {
                clearInterval(timer);  // Para o cronômetro
            }

            alert("Tempo total: " + elapsedDisplay.textContent);
            elapsedTime = 0;
            updateDisplay();
            playButton.disabled = false;
            pauseButton.disabled = true;
            stopButton.disabled = true;
            saveState();
            localStorage.setItem(runningTaskKey, '');  // Remove a tarefa do "running"
        }

        // Adiciona os eventos aos botões
        playButton.addEventListener("click", startTimer);
        pauseButton.addEventListener("click", pauseTimer);
        stopButton.addEventListener("click", stopTimer);

        // Inicializa o display do cronômetro
        updateDisplay();

        // Carrega o estado do cronômetro ao abrir o modal
        loadState();

        // Quando o modal for fechado, limpamos a lógica
        document.getElementById('modalTaskChronometer_{{ $task['id'] }}_{{ $list_id }}').addEventListener('hidden.bs.modal', function () {
            clearInterval(timer);  // Remove qualquer intervalo em execução
        });
    });
</script>
