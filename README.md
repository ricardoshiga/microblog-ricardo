# microblog-ricardo
 Exemplo de site dinamico de noticias

#Sobre areaa do site

## PÚBLICA

Páginas que **não precisam de autenticação** para o acesso.

São as paginas na  raiz do projeto: index, noticias, login e resultado.


### ADMINISTRATIVA

Páginas qeu **precisam de autenticação** para o acesso sendo qeu algumas delas 
tem provilégio de acesso diferenciados.

São as páginas contidas na pasta **admin** do projeto:
index, usuarios, usuario-insere, usuario-atualiza, usuario-exclui, noticias, noticia-insere, noticia-atualiza, noticia-exclui e não-atualizado.

### Privilegios de acesso

Usuários do tipo **admin**, podem acessar/modificar **TUDO**.

Usuários do tipo **editor**, podem aacessar/modificar **somente** seus próprios
dados e suas próprias notícias. Ou seja, **não podem** por exemplo, administrar outros usuários.