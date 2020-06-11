const btnPost = document.querySelector('.btn-post');
const addPostForm = document.querySelector('.add_post');
const btnExitPost = document.querySelector('.btn-exit-post');

btnPost.addEventListener('click',show_post);
btnExitPost.addEventListener('click',none_post);

function show_post() {
    addPostForm.classList.remove('none');
}

function none_post() {
    addPostForm.classList.add('none');
}