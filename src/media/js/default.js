function onError(err) {
  console.log(err)
  Joomla.renderMessages({error: ['Something blew up!']});
}

function onSuccess(resp) {
  let response;
  try {
    response = JSON.parse(resp);
  } catch (error) {
    throw new Error('Failed to parse JSON');
  }

  if (response.error || !response.success) {
    onError(response);
  }  else {
    Joomla.renderMessages({message: ['All static assets were invalidated 🎉']});
    button.removeAttribute('disabled');
  }
}

const button = document.querySelector('.js_modInvalidatecach');
if (button && Joomla && Joomla.request && typeof Joomla.request === 'function') {
  button.addEventListener('click', () => {
    button.setAttribute('disabled', '');
    Joomla.request({
      url: `index.php?option=com_ajax&format=json&module=invalidatecache&method=invalidate&${button.dataset.token}=1`,
      method: 'POST',
      onSuccess: onSuccess,
      onError: onError,
    });
  });
  button.removeAttribute('disabled');
}
