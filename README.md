# 🔐 TOTP Code Generator

This project is a **6-digit TOTP (Time-based One-Time Password) generator**, fully **client-side** (pure HTML+JS), with an optional **PHP version** to hide sensitive parameters.

## 🧩 Features

- Generates TOTP codes compatible with Google Authenticator, Microsoft Authenticator, and similar apps.
- Accepts multiple `secret` and `name` pairs via GET parameters (example: `index.htm?secret=ABC123&name=Account1&secret=DEF456&name=Account2`).
- Automatically saves secrets and names in **LocalStorage** for persistence across sessions.
- Displays either the service name or the secret, toggling with a click.
- Quick copy of TOTP codes to clipboard by clicking the code.
- Progress bar showing the remaining time until the next TOTP refresh.
- Clean, modern, and responsive interface using pure HTML/CSS/JavaScript.
- **Optional PHP version** to inject secrets directly into the HTML and hide URL parameters.

## 🚀 How to Use

1. Open `index.htm` passing the `secret` and `name` parameters through the URL:
```html
index.htm?secret=SECRET1&name=Google%20Account1&secret=SECRET2&name=Outlook%20Account2
```

2. The site automatically saves the data into LocalStorage. On future visits, codes will load even without URL parameters.

3. Click on the names to toggle between showing the service name and the secret.

4. Click on the TOTP code to quickly copy it to your clipboard.

## 📦 PHP Version

- `index.php` dynamically generates HTML embedding the `secret` and `name` pairs, **without exposing them through the URL**.

- Ideal for use cases where sensitive data needs better protection.

---

# 🔐 Gerador de Códigos TOTP

Este projeto é um **gerador de códigos TOTP de 6 dígitos** baseado em navegador, totalmente **client-side** (HTML+JS), com uma opção de versão em **PHP** para ocultar os parâmetros sensíveis.

## 🧩 Funcionalidades

- Gera códigos TOTP (Time-based One-Time Password) compatíveis com Google Authenticator, Microsoft Authenticator e similares.
- Recebe múltiplos pares de `secret` e `name` via parâmetros GET (ex: `index.htm?secret=ABC123&name=Conta1&secret=DEF456&name=Conta2`).
- Armazena os códigos localmente usando **LocalStorage** para persistência entre sessões.
- Exibe o nome do serviço ou o segredo, alternando com um clique.
- Cópia rápida dos códigos para a área de transferência ao clicar.
- Barra de progresso indicando o tempo restante para renovação do TOTP.
- Interface simples, moderna e responsiva, baseada apenas em HTML/CSS/JavaScript puro.
- **Versão PHP** opcional para injetar os secrets diretamente no HTML e esconder parâmetros da URL.

## 🚀 Como usar

1. Acesse `index.htm` passando os parâmetros `secret` e `name` via URL:
```html
index.htm?secret=SECRETO1&name=Google%20Conta1&secret=SECRETO2&name=Outlook%20Conta2
```

2. O site salva automaticamente os dados no LocalStorage. Nas próximas visitas, os códigos serão carregados mesmo sem URL.

3. Clique nos nomes para alternar entre ver o nome e o segredo.

4. Clique no código TOTP para copiá-lo rapidamente para sua área de transferência.

## 📦 Versão PHP

- `index.php` gera dinamicamente o HTML já com os pares `secret` e `name` embutidos no código, **sem necessidade de expor os secrets pela URL**.

- Ideal para cenários onde é necessário manter os parâmetros mais protegidos.
