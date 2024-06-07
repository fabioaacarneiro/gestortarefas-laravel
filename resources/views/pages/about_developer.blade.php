@extends('templates.login_layout') @section('content')

@section('content')

    @include('partials.visitant.nav')

    <div class="container my-5">
        <header class="mb-4 text-center">
            <img src="{{ asset('assets/img/perfil.jpg') }}" alt="Foto de Fabio A. A. Carneiro"
                class="rounded-circle mx-auto d-block mb-3" style="width: 250px;">
            <h1 class="display-4">Fabio A. A. Carneiro</h1>
            <p class="lead">Telefone / Whatsapp: (19) 9 8182-3868</p>
            <p class="lead">LinkedIn: <a href="https://www.linkedin.com/in/fabio-carneiro-coder"
                    class="text-info">linkedin.com/in/fabio-carneiro-coder</a></p>
            <p class="lead">GitHub: <a href="https://github.com/fabioaacarneiro/fabioaacarneiro"
                    class="text-info">github.com/fabioaacarneiro</a></p>
            <a href="{{ asset('assets/pdf/Fabio_Carneiro.pdf') }}" class="btn btn-success text-dark mt-3" download>Baixe
                meu Currículo</a>

        </header>
        <section class="mb-5">
            <h2 class="border-bottom border-info pb-2 mb-3">Formação</h2>
            <div class="mb-3">
                <h5>FAC, Campinas SP — Engenharia de Software</h5>
                <p class="text-muted">Agosto de 2020 - Dezembro de 2024, Campinas - SP</p>
            </div>
        </section>
        <section class="mb-5">
            <h2 class="border-bottom border-info pb-2 mb-3">Resumo</h2>
            <p>Sou desenvolvedor Full Stack PHP - Laravel e Desenvolvedor de automações com Python e PHP, possuo experiência
                com Bootstrap, Tailwind, HTML, HTMX, jQuery, JS, React, Python, MVC, MariaDB, MySQL, Linux (desde 2004),
                entre
                outras
                tecnologias.</p>
        </section>
        <section class="mb-5">
            <h2 class="border-bottom border-info pb-2 mb-3">Experiência</h2>
            <div class="mb-3">
                <h5>Imobiliária Jazz, Campinas - SP — Desenvolvimento de Software</h5>
                <p class="text-muted">Desde de Abril de 2023</p>
                <ul>
                    <li>Serviço autônomo criado com PHP e Laravel, para otimização e melhoria na qualificação de anúncios de
                        mais de 3 mil imóveis nos principais portais imobiliários do Brasil incluindo Grupo OLX.</li>
                    <li>Script para leitura e manipulação de planilhas em PHP.</li>
                    <li>Coleta de dados de PDF com PHP e expressão regular.</li>
                    <li>Consumo e integração de APIs de CRMs em PHP e Python.</li>
                    <li>Script para processamento de XML com PHP.</li>
                    <li>Desenvolvimento de RPA usando Selenium em PHP e Python.</li>
                    <li>Desenvolvimento de App desktop (Jazz Single):
                        <ul>
                            <li>Linguagem principal Python;</li>
                            <li>Interface do App criada com QT6(PySide6);</li>
                            <li>Documentação Criada com HTML e CSS;</li>
                            <li>Geração de descrições de imóveis geradas por inteligência artificial com o motor GPT-3.5 e
                                GPT-4;</li>
                            <li>ChatBot usando Inteligência Artificial GPT-3.5 para auxílio dos corretores;</li>
                            <li>Sistema de disparo de mensagem em massa por WhatsApp.</li>
                        </ul>
                    </li>
                    <li>Desenvolvimento de App desktop (Jazz Finder Realtors):
                        <ul>
                            <li>Linguagem principal Python;</li>
                            <li>Interface do App criada com QT6(PySide6);</li>
                            <li>Coleta massiva de dados públicos de Corretores credenciados pelo CRECI SP usando Python e
                                Selenium com filtro de ativo ou não e cidade de atuação;</li>
                        </ul>
                    </li>
                </ul>
            </div>
        </section>
        <section class="mb-5">
            <h2 class="border-bottom border-info pb-2 mb-3">Tecnologias</h2>
            <p>Python, PHP, Java, Spring Framework, HTML, CSS, PySide6 (QT6), Selenium, Pandas, NumPy, PIP, Composer.</p>
        </section>
        <section class="mb-5">
            <h2 class="border-bottom border-info pb-2 mb-3">Alguns Projetos</h2>
            <div class="mb-3">
                <h5>Criador e desenvolvedor do projeto RamTask, Campinas</h5>
                <p>Saas para gestão pessoal de fluxo de trabalho e tarefas. O Core da aplicação é o Framework Laravel 10 e
                    PHP 8.3. Atualmente é minha principal ferramenta de controle e assistência digital do meu fluxo de
                    trabalho e estudo. <a href="https://ramtask.com" class="text-info">Acesse: ramtask.com</a></p>
                <ul>
                    <li>Deploy com servidor Debian 12 - VPS.</li>
                    <li>Nginx.</li>
                    <li>Login via Google.</li>
                    <li>Banco de dados MySQL.</li>
                    <li>Laravel MVC.</li>
                    <li>Bootstrap.</li>
                    <li>Sistema simples de gamificação.</li>
                    <li>Versionamento no Github.</li>
                </ul>
            </div>
            <div class="mb-3">
                <h5>Oficina do Riso, Campinas</h5>
                <p>Projeto web freelance para um curso particular de teatro criado com Framework Codeigniter 4 e PHP 8.1.
                </p>
                <ul>
                    <li>Deploy via FTP usando Github Actions.</li>
                    <li>Banco de dados MySQL.</li>
                    <li>Codeigniter MVC.</li>
                    <li>Bootstrap.</li>
                    <li>HTML.</li>
                    <li>CSS.</li>
                </ul>
            </div>
        </section>
        <section>
            <h2 class="border-bottom border-info pb-2 mb-3">Cursos</h2>
            <ul>
                <li><strong>DIO - Digital Innovation One:</strong> Desenvolvimento Avançado com Java, Desenvolvimento com
                    Spring Boot.</li>
                <li><strong>Faculdade Anhanguera:</strong> Análise de dados, Estruturas de dados em Python e Desenvolvimento
                    avançado em Python.</li>
                <li><strong>Centro SENAI de Tecnologias Educacionais:</strong> Lógica de programação, Tecnologia da
                    Informação e Comunicação.</li>
                <li><strong>IPED - Instituto Politécnico de Ensino à Distância:</strong> Curso de linguagem PHP.</li>
            </ul>
        </section>
    </div>

@endsection
