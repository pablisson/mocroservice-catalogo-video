FROM php:8.2-fpm

RUN apt-get update && apt-get install -y git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    bash \
    && rm -rf /var/lib/apt/lists/*

RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# cria o usuário devcontainer adiciona ao grupo www-data e sudo, 
# da permissão de escrita na pasta /var/www
#
# echo "devcontainer ALL=(ALL) NOPASSWD:ALL" >> /etc/sudoers \
# O camando acima dá ao usuário devcontainer acesso root semprecisar de senha
# isso é útil para o ambiente de desenvolvimento e péssimo para produção
#
# usermod -u 1000 devcontainer \
# O comando acima muda o id do usuário devcontainer para 1000
# Isso é útil para evitar problemas de permissão entre o usuário do host e o usuário do container
#
# chmod -R 775 /var/www
# O comando acima dá permissão de escrita para o grupo www-data
# Isso é útil para evitar problemas de permissão entre o usuário do host e o usuário do container
# porém isso pode ser um problema para o ambiente de produção
RUN useradd -ms /bin/bash devcontainer && echo "devcontainer ALL=(ALL) NOPASSWD:ALL" >> /etc/sudoers \
    usermod -u 1000 devcontainer \
    && usermod -aG sudo devcontainer \
    && usermod -aG www-data devcontainer \
    && chown -R devcontainer:www-data /var/www \
    && chmod -R 775 /var/www 

WORKDIR /var/www

# Copia o composer da imagem oficial pra dentro da sua imagem
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Instala a extensão do redis para que o código php identifique o redis
# também é possível adicionar uma extesão via composer
# composer require predis/predis
# Porém a predis é mais lenta porque foi desenvolvida em php. 
# A redis via pecl é compilada em c
RUN pecl install -o -f redis \
    &&  rm -rf /tmp/pear \
    &&  docker-php-ext-enable redis

RUN echo 'export HISTFILE=/home/devcontainer/.bash_history' >> /home/devcontainer/.bashrc \
    && echo 'PROMPT_COMMAND="history -a; $PROMPT_COMMAND"' >> /home/devcontainer/.bashrc \
    && chown devcontainer:devcontainer /home/devcontainer/.bash_history
    
USER devcontainer

EXPOSE 9000