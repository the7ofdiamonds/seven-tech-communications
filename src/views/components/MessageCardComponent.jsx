import React, { useState } from 'react';
import { useDispatch } from 'react-redux';

import { sendEmail } from '../../controllers/contactSlice';

function MessageCardComponent(props) {
  const { page } = props;

  const dispatch = useDispatch();

  const [formData, setFormData] = useState({
    first_name: '',
    last_name: '',
    email: '',
    subject: '',
    message: '',
  });

  const { firstname, lastname, email, subject, msg } = formData;

  const handleInputChange = (e) => {
    const { name, value } = e.target;
    setFormData({
      ...formData,
      [name]: value,
    });
  };

  const handleSubmit = async () => {
    dispatch(sendEmail({page, firstname, lastname, email, subject, msg}));
  };

  return (
    <>
      <form className="message-card">
        <table>
          <tbody>
            <tr>
              <td>
                <input
                  type="text"
                  name="firstname"
                  className="input"
                  id="first_name"
                  placeholder="First Name"
                  onChange={handleInputChange}
                  value={firstname}
                />
              </td>
              <td>
                <input
                  type="text"
                  name="lastname"
                  className="input"
                  id="last_name"
                  placeholder="Last Name"
                  onChange={handleInputChange}
                  value={lastname}
                />
              </td>
            </tr>
            <tr>
              <td>
                <input
                  name="email"
                  type="email"
                  id="contact_email"
                  className="input"
                  placeholder="Email"
                  onChange={handleInputChange}
                  value={email}
                />
              </td>
              <td>
                <input
                  name="subject"
                  type="text"
                  id="contact_subject"
                  className="input"
                  placeholder="Subject"
                  onChange={handleInputChange}
                  value={subject}
                />
              </td>
            </tr>
            <tr>
              <td colSpan={2}>
                <textarea
                  name="msg"
                  type="text"
                  id="contact_message"
                  placeholder="Message"
                  onChange={handleInputChange}
                  value={msg}></textarea>
              </td>
            </tr>
            <tr>
              <td colSpan={2}>
                <input type="hidden" name="action" value="thfw_email_contact" />
                <button
                  className="sendmsg"
                  id="contact_submit"
                  name="submit"
                  type="button"
                  value="submit"
                  onClick={handleSubmit}>
                  <h3>SEND</h3>
                </button>
              </td>
            </tr>
          </tbody>
        </table>
      </form>
    </>
  );
}

export default MessageCardComponent;
