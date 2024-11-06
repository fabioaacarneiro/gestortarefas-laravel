<!-- Modal do Cronômetro -->
<div class="modal fade" id="{{ $modal_id }}" tabindex="-1" aria-labelledby="{{ $modal_id }}Label" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="text-info"><strong>{{ $list_name }}</strong> - <em>{{ $name }}</em></h4>
                <button id="editTimer_{{ $modal_id }}" class="btn btn-secondary btn-lg"><i class="fas fa-pencil"></i></button>
            </div>
            <div class="p-3 modal-body">
                <div class="d-flex flex-column justify-content-center"">
                    <div class="d-flex justify-content-center">
                        <p id="timerDisplay_{{ $modal_id }}" class="fs-2">00:00</p> <!-- Exibição do cronômetro -->
                    </div>
                    <div id="messageContainer_{{ $modal_id }}"></div>
                    <div class="d-flex justify-content-center mb-4">
                        <div class="input-group w-50" id="updateTimeContainer_{{ $modal_id }}" style="display: none">
                            <input class="form-control" type="time" step="2" name="inputTimerDisplay_{{ $modal_id }}" id="inputTimerDisplay_{{ $modal_id }}">
                            <button  class="btn btn-success" id="updateTimeButton_{{ $modal_id }}">
                                <i class="fas fa-save"></i>
                            </button>
                            <button  class="btn btn-danger" id="cancelUpdateTimeButton_{{ $modal_id }}">
                                <i class="fas fa-cancel"></i>
                            </button>
                        </div>
                    </div>
                </div>
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
        const editTimerButton = document.getElementById("editTimer_{{ $modal_id }}")
        const updateTimeContainer = document.getElementById("updateTimeContainer_{{ $modal_id }}")
        const inputTimerDisplay = document.getElementById("inputTimerDisplay_{{ $modal_id }}")
        const updateTimeButton = document.getElementById("updateTimeButton_{{ $modal_id }}")
        const cancelUpdateTimeButton = document.getElementById("cancelUpdateTimeButton_{{ $modal_id }}")

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

            console.log(`isRunning value: ${isRunning}`)

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
            const hours = Math.floor(elapsedTime / 3600);
            const minutes = Math.floor((elapsedTime % 3600) / 60);
            const seconds = elapsedTime % 60;
            elapsedDisplay.textContent = `${String(hours).padStart(2, '0')}:${String(minutes).padStart(2, '0')}:${String(seconds).padStart(2, '0')}`;
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
                    messageContainer.innerHTML = `<p id="messageError_{{ $modal_id }}" class="text-center text-danger">Já existe uma tarefa em progresso!... ${timeLess}</p>`;

                    // Intervalo para reduzir o timeLess
                    let countDownMessageTimer = setInterval(function() {
                        timeLess--;  // Decrementa o tempo
                        // Atualiza a mensagem com o tempo restante
                        messageContainer.innerHTML = `<p class="text-center text-danger">Já existe uma tarefa em progresso!... ${timeLess}</p>`;

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
                editTimerButton.disabled = true;
                pauseButton.disabled = false;
            }
        }

        // Função para pausar o cronômetro
        function pauseTimer() {
            if (isRunning) {
                clearInterval(timer);
                isRunning = false;
                playButton.disabled = false;
                editTimerButton.disabled = false;
                pauseButton.disabled = true;
                saveState();
                localStorage.setItem("running_task", ''); // Remove o cronômetro em execução
            }
        }

        // Edição do tempo do cronomêtro       
        editTimerButton.addEventListener("click", () => {
            elapsedDisplay.style.display = "none"
            updateTimeContainer.style.display = "flex"
        })
        
        cancelUpdateTimeButton.addEventListener("click", () => {
            elapsedDisplay.style.display = "flex"
            updateTimeContainer.style.display = "none"
        })
        
        updateTimeButton.addEventListener("click", () => {
            let [h, m, s] = inputTimerDisplay.value.split(":")

            h = parseInt(h)
            m = parseInt(m)
            s = parseInt(s)

            let total = h * 60 *60 + m * 60 + s

            updateDatabase(total)
            localStorage.setItem(`elapsedTime_${modalTaskId}`, total);
            elapsedTime = total

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
            
            elapsedDisplay.style.display = "flex"
            updateTimeContainer.style.display = "none"
        })

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
