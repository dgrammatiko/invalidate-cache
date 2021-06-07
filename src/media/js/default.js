const renderMessage = (type, msg) => {
  if (Joomla && Joomla.renderMessages && typeof Joomla.renderMessages === 'function') {
    Joomla.renderMessages({[type]: msg});
  } else {
    alert(msg);
  }
}

const onClick = (button) => {
  button.addEventListener('click', async () => {
    let resp;
    button.setAttribute('disabled', '');
    try {
      resp = await fetch(`index.php?option=com_ajax&format=json&module=invalidatecache&method=invalidate&${button.dataset.token}=1`, {method: 'POST'});
    } catch(err) {
      console.log(err);
      renderMessage('error', ['Something blew up!']);
    }

    if (typeof resp !== 'object' || !resp.ok || resp.statusText !== 'OK') {
      renderMessage('error', ['Something blew up!']);
    }  else {
      renderMessage('success', ['All static assets were invalidated 🎉']);
      button.removeAttribute('disabled');
    }
  });
  button.removeAttribute('disabled');
}

[].slice.call(document.querySelectorAll('.js_modInvalidatecach')).map((button) => onClick(button));
