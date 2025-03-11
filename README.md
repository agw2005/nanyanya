# Nanyanya
[Figma](https://www.figma.com/design/xDqzNQ8XAzME0slYTKwjUX/Nanyanya?node-id=0-1&t=ghXLgpj0SrmOVM7J-1) | [Trello](https://trello.com/invite/b/67b9cc3e0671324c1df80e00/ATTI460712c925907d89575f66e77d5ff5a1AAA45DFA/rpl-kelompok-5) | [Formal Document](https://docs.google.com/document/d/1iB67vTSJZnU37vcEuYlXQ_PPENWRjMf1C7oUduMxCSw/edit?tab=t.0) | [Userflow](https://app.diagrams.net/#Hagw2005%2Fnanyanya%2Fmain%2Fuserflow.drawio#%7B%22pageId%22%3A%22C5RBs43oDa-KdzZeNtuy%22%7D)
___
"Nanyanya" adalah platform web yang memungkinkan pengguna untuk menyelenggarakan kuis bagi pengguna lain untuk ikut serta dalam kuis tersebut. Pengguna dapat membuat kuesioner mereka sendiri, baik public atau limited, atau ikut serta dalam kuis buatan pengguna lainnya. Situs web Nanyanya dapat digunakan oleh para pendidik untuk menyelenggarakan kuis bagi siswa, juga dapat digunakan untuk siswa dalam membuat flashcard sebagai alat active-recalling, untuk statistikawan sebagai medium penyelenggara survey  atau bagi siapa saja untuk membuat kuis rekreasional.

# Commit Guidelines
This project uses the form of type `[PURPOSE]([SCOPE]):[MESSAGE]`

`[PURPOSE]` refers to the purpose of the commit, the content is according to the table below.
| PURPOSE-value | Description |
|----------|----------|
| feat   | When changes adds a new feature or functionality   |
| fix   | When changes fixes a bug in the codebase   |
| chore   | When changes doesn't affect code logic, such as updating dependencies, CI/CD configurations, or scripts   |
| refactor   | When changes improve the code without changing functionality   |
| docs   | When the changes updates the documentation   |

`[SCOPE]` indicates the name of the file(s) that is changed.

`[MESSAGE]` is a short summary plus occasionally a long explanation or reference to other relative issues
```bash
# Good commit message following conventional guidelines
git commit -m "feat(auth.js): add JWT-based authentication"
git commit -m "fix(login.jsx): resolve race condition in login flow"
```

## 2. Atomic & Focused
Do not mix several independent changes in one commit.
```bash
# Good commit
git commit -m "Add user authentication"

# Bad commit
git commit -m "Add user authentication AND update UI styles"
```

## 3. Descriptive Message
What the commit does and why the change was made.
```bash
# Good commit message
git commit -m "Fix Correct null pointer exception in user login"
# Bad commit message
git commit -m "Fix bug"
```
