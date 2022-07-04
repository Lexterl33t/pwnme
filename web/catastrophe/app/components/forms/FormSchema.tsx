import { useEffect } from 'react';
import * as yup from 'yup';
import { Field, Form, Formik } from 'formik';
import { useRouter } from 'next/router'

export default function FormSchema() {
    const router = useRouter()
    useEffect(() => {
        document.title = "Forum | Cat@Strophe"
    })

    const schema = yup.object().shape({
        message: yup.string()
            .required('')
            .min(1, "Votre message ne peut être vide")
            .max(200, "La limite est de 200 charactères")
    })

    async function uploadMessage(content) {
        const payload = JSON.parse(JSON.stringify(content))
        const url     = '/'
        const body    = {
            message: payload.message
        }

        try {
            await fetch(
                url,
                {
                    body: JSON.stringify(body),
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    method: 'POST'
                }
            )

            router.push('/')
        } catch (e) {
            console.error(e)
        }
    }

    return (
        <Formik
            initialValues={{
                message: ''
            }}
            validationSchema={schema}
            onSubmit={(content, { setSubmitting }) => {
                uploadMessage(content)
                setSubmitting(false)
            }}
        >
            {({ errors, touched }) => (
                <Form className="flex flex-col p-2">
                    <h1>Formulaire</h1>

                    <Field
                        className="rounded-lg"
                        id="message"
                        component="textarea"
                        rows="4"
                        name="message"
                        type="text"
                        spellCheck="false"
                        autoComplete="off"
                        placeholder="Envoyez un message"
                    />
                    { errors.message && touched.message && <div className='error'>{errors.message}</div> }

                    <button type="submit">Envoyer</button>
                </Form>
            )}
        </Formik>
    )
}