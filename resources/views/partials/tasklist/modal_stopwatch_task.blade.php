<!-- Modal do Cronômetro -->
<div class="modal fade" id="{{ $modal_id }}" tabindex="-1" aria-labelledby="{{ $modal_id }}Label" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="text-info"><strong>{{ $list_name }}</strong> - <em>{{ $task_name }}</em></h4>
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

        const modalTaskId = "{{ $modal_id }}";
        const listName = "{{ $list_name }}"
        const listId = "{{ $list_id }}"
        const taskName = "{{ $task_name }}"
        const taskId = "{{ $task_id }}"
        const taskIdentity = `${listName}_${taskName}_${listId}_${taskId}`

        const url = `{{ route('getTaskTime') }}?task_id=${taskId}`;

        let elapsedDisplay = document.getElementById(`timerDisplay_${modalTaskId}`);
        let runningTaskKey = `runningTaskId_${modalTaskId}`;

        const playButton = document.getElementById("playButton_{{ $modal_id }}");
        const pauseButton = document.getElementById(`pauseButton_${modalTaskId}`);
        const editTimerButton = document.getElementById("editTimer_{{ $modal_id }}")
        const updateTimeContainer = document.getElementById("updateTimeContainer_{{ $modal_id }}")
        const inputTimerDisplay = document.getElementById("inputTimerDisplay_{{ $modal_id }}")
        const updateTimeButton = document.getElementById("updateTimeButton_{{ $modal_id }}")
        const cancelUpdateTimeButton = document.getElementById("cancelUpdateTimeButton_{{ $modal_id }}")

        const actualTaskRunningContainer = document.getElementById("actual_task_running_container")
        const actualTaskRunningMessage = document.getElementById("actual_task_running_message")
        
        let timer;
        let isRunning = false;
        let elapsedTime = 0;
        let startTime = 0;

        // atualizar com o banco de dados
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

        // Função para sincronizar o tempo entre localStorage e o banco de dados
        function synchronizeTime(dbElapsedTime, dbRunningState) {
            const savedTime = localStorage.getItem(`elapsedTime_${modalTaskId}`);
            const savedRunningState = localStorage.getItem(`isRunning_${modalTaskId}`);

            if (savedTime) {
                elapsedTime = parseInt(savedTime);
            }

            // Se o tempo do localStorage for maior que o do banco, envia para o banco
            if (elapsedTime > dbElapsedTime) {
                updateDatabase(elapsedTime, dbRunningState);
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
        function updateDatabase(elapsedTime, isRunning) {
            const updateUrl = `{{ route('updateTaskTime') }}?task_id=${taskId}&elapsed_time=${elapsedTime}`;

            console.log(`isRunning value: ${isRunning}`)

            axios.post(updateUrl, { 
                    task_id: taskId,
                    list_id: listId,
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
            const runningTask = `${listName}_${taskName}_${listId}_${taskId}`
            localStorage.setItem(`elapsedTime_${modalTaskId}`, elapsedTime);
            localStorage.setItem('running_task', runningTask);
        }

        // Função para verificar se algum outro cronômetro está em execução
        function existAnotherRunningTask () {
            const currentRunningTask = localStorage.getItem("running_task");
            console.log(`currentRunningTask: ${currentRunningTask}`)
            console.log(`currentTask: ${modalTaskId}`)
            if (currentRunningTask && currentRunningTask !== taskIdentity) {
                return true
            }
            return false
        }

        // Função para recuperar o nome da tarefa em execução
        function getRunningTaskName() {
            const [
                listNameRunning, 
                taskNameRunning, 
                listIdRunning, 
                taskIdRunnin
            ] = localStorage.getItem("running_task").split("_");

            return [listNameRunning, taskNameRunning]
        }

        // Função para iniciar o cronômetro
        function startTimer() {
            console.log('startTimer')
            if (!isRunning) {

                if(actual_task_running_container) {
                    actualTaskRunningContainer.style.display = 'flex'
                    actualTaskRunningMessage.innerHTML = `<span class="bg-success py-1 pe-2 rounded" id="btnMessageRunningTask"><i class="bi bi-stopwatch ms-2 me-1"></i><em><strong>${taskName}</strong> da lista <strong>${listName}</strong></em></span>`
                }

                const localCurrentTime = localStorage.getItem(`elapsedTime_${modalTaskId}`)
                updateDatabase(localCurrentTime, true)
                
                // Verifica se já existe outro cronômetro em execução
                if (existAnotherRunningTask()) {
                    
                    updateDatabase(localCurrentTime, false)
                    console.log(getRunningTaskName())
                    const [listNameRunning, taskNameRunning] = getRunningTaskName()

                    // Se outro cronômetro está rodando, exibe um alerta
                    let timeLess = 10;

                    // Exibe a mensagem com o tempo restante
                    const messageContainer = document.getElementById("messageContainer_{{ $modal_id }}");

                    messageContainer.innerHTML = '<p class="text-center"><strong><em>Processando...</em></strong></p>'

                    // Intervalo para reduzir o timeLess
                    let countDownMessageTimer = setInterval(function() {
                        // Atualiza a mensagem com o tempo restante
                        messageContainer.innerHTML = `<div id="messageError_{{ $modal_id }}">
                            <p class="text-center text-danger">
                            Existe uma tarefa em execução neste momento
                            </p>
                            <p class="text-center">
                            A tarefa <strong><em>${taskNameRunning}</em></strong> da lista <strong><em>${listNameRunning}</em></strong> está em execução agora.
                            </p>
                            <p class="text-center text-danger">
                            saindo... ${timeLess}
                            </p>
                            </div>`
                                        
                        timeLess--;  // Decrementa o tempo

                        // Se o contador chegar a 0, para o intervalo e limpa a mensagem
                        if (timeLess <= 0) {
                            clearInterval(countDownMessageTimer); // Para o contador
                            messageContainer.innerHTML = ""; // Limpa a mensagem
                        }
                    }, 1000);
                    
                    return
                }

                // Marca este cronômetro como o em execução
                localStorage.setItem("running_task", taskIdentity);
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
                
                actualTaskRunningContainer.setAttribute('style', 'display:none !important')
                actualTaskRunningMessage.innerHTML = ``
                
                const localCurrentTime = localStorage.getItem(`elapsedTime_${modalTaskId}`)
                updateDatabase(localCurrentTime, false)
                
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
            inputTimerDisplay.value = elapsedDisplay.textContent
        })
        
        cancelUpdateTimeButton.addEventListener("click", () => {
            elapsedDisplay.style.display = "flex"
            updateTimeContainer.style.display = "none"
        })
        
        updateTimeButton.addEventListener("click", () => {
            if (inputTimerDisplay.value === "") {
                let timeLess = 3

                const messageContainer = document.getElementById("messageContainer_{{ $modal_id }}");
                    messageContainer.innerHTML = `<p id="messageError_{{ $modal_id }}" class="text-center text-danger">Valor informado é inválido!... ${timeLess}</p>`;

                // Intervalo para reduzir o timeLess
                let countDownMessageTimer = setInterval(function() {
                        timeLess--;  // Decrementa o tempo
                        // Atualiza a mensagem com o tempo restante
                        messageContainer.innerHTML = `<p class="text-center text-danger">Valor informado é inválido!... ${timeLess}</p>`;

                        // Se o contador chegar a 0, para o intervalo e limpa a mensagem
                        if (timeLess <= 0) {
                            clearInterval(countDownMessageTimer); // Para o contador
                            messageContainer.innerHTML = ""; // Limpa a mensagem
                            
                            elapsedDisplay.style.display = "none"
                            updateTimeContainer.style.display = "flex"
                        }
                    }, 1000);
                    
            }

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
