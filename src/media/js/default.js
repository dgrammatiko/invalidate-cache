const renderMessage = (type, msg) => {
  if (Joomla && Joomla.renderMessages && typeof Joomla.renderMessages === 'function') {
    Joomla.renderMessages({[type]: msg});
  } else {
    alert(msg);
  }
}

const onClick = (button) => {
  button.addEventListener('click', async (event) => {
    let resp;
    button.setAttribute('disabled', '');
    const url = new URL(`${button.dataset.url}index.php?option=com_ajax&format=json&module=invalidatecache&method=invalidate&${button.dataset.token}=1`);
    console.log(url.href);
    if (!url) return;

    try {
      resp = await fetch(url, {method: 'POST'});
    } catch(err) {
      console.log(err);
      renderMessage('error', ['Something blew up!']);
    }

    if (typeof resp !== 'object' || !resp.ok) {
      renderMessage('error', ['Something blew up!']);
    }  else {
      renderMessage('success', ['All static assets were invalidated 🎉']);
      button.removeAttribute('disabled');
    }
  });
  button.removeAttribute('disabled');
}

[].slice.call(document.querySelectorAll('.js_modInvalidatecach')).map((button) => onClick(button));
