const renderMessage = (type, msg) => {
  if (Joomla && Joomla.renderMessages && typeof Joomla.renderMessages === 'function') {
    Joomla.renderMessages({[type]: msg});
  } else {
    alert(msg);
  }
}

[...document.querySelectorAll('.js_modInvalidatecach')]
.forEach((button) => {
  button.addEventListener('click', async (event) => {
    let resp;
    const el = event.currentTarget;
    el.setAttribute('disabled', '');
    const url = new URL(`${el.dataset.url}administrator/index.php?option=com_ajax&format=json&module=invalidatecache&method=invalidate&${el.dataset.token}=1`);
    if (!url) return;

    try {
      resp = await fetch(url, {method: 'GET'});
    } catch(err) {
      console.error(err);
      renderMessage('error', ['Something blew up!']);
    }

    if (typeof resp !== 'object' || resp.status !== 200) {
      console.error(resp);
      renderMessage('error', ['Something blew up!']);
    }  else {
      renderMessage('success', ['All static assets were invalidated 🎉']);
      el.removeAttribute('disabled');
    }
  });
  button.removeAttribute('disabled');
});
