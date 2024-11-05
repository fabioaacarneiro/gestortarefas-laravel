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
                <div id="messageContainer_{{ $modal_id }}"></div>
                <div class="d-flex justify-content-center" role="group" aria-label="Timer Controls">
                    <div class="btn-group">
                        <button id="playButton_{{ $modal_id }}" class="btn btn-success btn-lg"><i class="fas fa-play"></i></button>
                        <button id="pauseButton_{{ $modal_id }}" class="btn btn-danger btn-lg" disabled><i class="fas fa-pause"></i></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal de Aviso: Cronômetro Já Em Execução -->
<div class="modal fade" id="modalAlert" tabindex="-1" aria-labelledby="modalAlertLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalAlertLabel">Atenção!</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Já existe um cronômetro em execução. Pause ou pare o cronômetro atual antes de iniciar outro.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>


<script>
    // A lógica agora será carregada apenas quando o modal for mostrado
    document.getElementById("{{ $modal_id }}").addEventListener('show.bs.modal', function () {
        const taskId = "{{ $task['id'] }}";
        const url = `{{ route('getTaskTime') }}?task_id=${taskId}`;

        axios.get(url, {
            headers: {
                'Accept': 'application/json',
            }
        })
        .then(response => {
            const taskData = response.data;

            // Recupera o tempo armazenado no banco
            const dbElapsedTime = taskData.data.elapsed_time; // Tempo do banco
            const dbRunningState = taskData.data.is_running;  // Estado de execução do banco

            // Sincroniza o localStorage com o banco
            synchronizeTime(dbElapsedTime, dbRunningState);
        })
        .catch(error => {
            console.error('Erro ao fazer requisição:', error.response ? error.response.data : error.message);
        });

        const modalTaskId = "{{ $modal_id }}";
        let elapsedDisplay = document.getElementById(`timerDisplay_${modalTaskId}`);
        let runningTaskKey = `runningTaskId_${modalTaskId}`;
        const playButton = document.getElementById(`playButton_${modalTaskId}`);
        const pauseButton = document.getElementById(`pauseButton_${modalTaskId}`);

        let timer;
        let isRunning = false;
        let elapsedTime = 0;
        let startTime = 0;

        // Função para sincronizar o tempo entre localStorage e o banco de dados
        function synchronizeTime(dbElapsedTime, dbRunningState) {
            const savedTime = localStorage.getItem(`elapsedTime_${modalTaskId}`);
            const savedRunningState = localStorage.getItem(`isRunning_${modalTaskId}`);

            if (savedTime) {
                elapsedTime = parseInt(savedTime);
            }

            // Se o tempo do localStorage for maior que o do banco, envia para o banco
            if (elapsedTime > dbElapsedTime) {
                updateDatabase(elapsedTime);
            } else {
                // Se o tempo do banco for maior, atualiza o localStorage
                localStorage.setItem(`elapsedTime_${modalTaskId}`, dbElapsedTime);
                elapsedTime = dbElapsedTime;
            }

            // Ajusta o estado do cronômetro
            if (savedRunningState === 'true' || dbRunningState === 1) {
                startTimer();
            }

            updateDisplay();
        }

        // Função para atualizar o banco de dados com o tempo
        function updateDatabase(elapsedTime) {
            const updateUrl = `{{ route('updateTaskTime') }}?task_id=${taskId}&elapsed_time=${elapsedTime}`;

            axios.post(updateUrl, { 
                    task_id: taskId,
                    elapsed_time: elapsedTime,
                    is_running: isRunning
                })
                .catch(error => {
                    console.error('Erro ao atualizar o tempo no banco:', error.response ? error.response.data : error.message);
                });
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

        // Função para verificar se algum outro cronômetro está em execução
        function existAnotherRunningTask () {
            const currentRunningTask = localStorage.getItem("running_task");
            console.log(`currentRunningTask: ${currentRunningTask}`)
            console.log(`currentTask: ${modalTaskId}`)
            if (currentRunningTask && currentRunningTask !== modalTaskId) {
                return true
            }
            return false
        }

        // Função para iniciar o cronômetro
        function startTimer() {
            if (!isRunning) {
                // Verifica se já existe outro cronômetro em execução
            
                if (existAnotherRunningTask()) {

                    console.log(existAnotherRunningTask())

                    // Se outro cronômetro está rodando, exibe um alerta
                    let timeLess = 3;

                    // Exibe a mensagem com o tempo restante
                    const messageContainer = document.getElementById("messageContainer_{{ $modal_id }}");
                    messageContainer.innerHTML = `<p id="messageError_{{ $modal_id }}" class="text-center text-danger">Já existe uma tarefa em progresso! - ${timeLess}</p>`;

                    // Intervalo para reduzir o timeLess
                    let countDownMessageTimer = setInterval(function() {
                        timeLess--;  // Decrementa o tempo
                        // Atualiza a mensagem com o tempo restante
                        messageContainer.innerHTML = `<p class="text-center text-danger">Já existe uma tarefa em progresso! - ${timeLess}</p>`;

                        // Se o contador chegar a 0, para o intervalo e limpa a mensagem
                        if (timeLess <= 0) {
                            clearInterval(countDownMessageTimer); // Para o contador
                            messageContainer.innerHTML = ""; // Limpa a mensagem
                        }
                    }, 1000);
                    
                    return
                }

                // Marca este cronômetro como o em execução
                localStorage.setItem("running_task", modalTaskId);
                isRunning = true;
                startTime = Date.now() - elapsedTime * 1000;
                timer = setInterval(function() {
                    elapsedTime = Math.floor((Date.now() - startTime) / 1000);
                    updateDisplay();
                    saveState();
                }, 1000);

                playButton.disabled = true;
                pauseButton.disabled = false;
            }
        }

        // Função para pausar o cronômetro
        function pauseTimer() {
            if (isRunning) {
                clearInterval(timer);
                isRunning = false;
                playButton.disabled = false;
                pauseButton.disabled = true;
                saveState();
                localStorage.setItem("running_task", ''); // Remove o cronômetro em execução
            }
        }

        // Adiciona os eventos aos botões
        playButton.addEventListener("click", startTimer);
        pauseButton.addEventListener("click", pauseTimer);

        // Inicializa o display do cronômetro
        updateDisplay();

        // Quando o modal for fechado, limpamos a lógica
        document.getElementById('modalTaskChronometer_{{ $task['id'] }}_{{ $list_id }}').addEventListener('hidden.bs.modal', function () {
            clearInterval(timer);  // Remove qualquer intervalo em execução
        });
    });
</script>
