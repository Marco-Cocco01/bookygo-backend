# Bookygo – Backend

Backend API ufficiale del progetto **Bookygo**.  
Repository di proprietà esclusiva del committente.

Questo repository contiene **solo logica di backend** ed espone API REST consumate da:
- Frontend Web
- App iOS
- App Android

---

## Stack Tecnologico
- Framework: **Laravel** (API-only)
- Database: **PostgreSQL**
- Autenticazione: **Laravel Sanctum**
- Architettura: modulare, API-first

---

## Principi Architetturali
- Backend unico centrale
- Tutta la logica di business risiede nel backend
- Nessuna logica di business nel frontend o nelle app
- API versionate (`/api/v1`)
- Codice modulare ed estendibile

---

## Regole di Sviluppo (OBBLIGATORIE)
- Branch principale: `main` (protetto)
- Vietati commit diretti su `main`
- Consegna **esclusivamente** tramite **Pull Request**
- Ogni blocco funzionale deve essere sviluppato su branch dedicato con naming: block/<numero>-<descrizione>
- Ogni Pull Request deve riferirsi a **un solo blocco**
- È vietato modificare blocchi già approvati senza autorizzazione scritta

---

## Workflow di Consegna
1. Creare branch dal `main`
2. Sviluppare il blocco assegnato
3. Aprire Pull Request verso `main`
4. Attendere review e approvazione del committente
5. Il merge viene effettuato **solo dal committente**

---

## Ambiente e Configurazione
- Le variabili di ambiente sono documentate in `.env.example`
- Il file `.env` **non deve mai essere committato**
- Nessuna credenziale reale deve comparire nel repository

---

## Testing e Qualità
- Ogni blocco deve essere testabile in modo indipendente
- I test di accettazione sono definiti nell’**Allegato C**
- Il codice deve essere leggibile, documentato e manutenibile

---

## Stato del Progetto
- Blocco 0: Setup repository e governance ✔️
- Blocchi successivi: in sviluppo secondo roadmap

---

## Proprietà e Diritti
- Il codice sorgente è di proprietà del committente
- È vietato il riutilizzo del codice per altri progetti
- Tutto il lavoro deve essere consegnato tramite questo repository

---

## Note Finali
Questo repository è parte di un progetto sviluppato a milestone.  
Il mancato rispetto delle regole di workflow invalida la consegna del blocco.
