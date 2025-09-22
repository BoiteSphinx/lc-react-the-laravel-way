import { useFormStatus } from "react-dom";
import { Form, useForm } from "@inertiajs/react";
import { store } from "@/routes/puppies";

export function NewPuppyForm() {
  const { setData, data } = useForm({
    name: '',
    trait: '',
    image: null as File | null,
  })

  return (
    <div className="mt-12 flex items-center justify-between bg-white p-8 shadow ring ring-black/5">
        <Form
          method="post"

          action={store()}
          className="mt-4 flex w-full flex-col items-start gap-4"
        >
          <div className="grid w-full gap-6 md:grid-cols-3">
            <fieldset className="flex w-full flex-col gap-1">
              <label htmlFor="name">Name</label>
              <input
                required
                value={data.name}
                className="max-w-96 rounded-sm bg-white px-2 py-1 ring ring-black/20 focus:ring-2 focus:ring-cyan-500 focus:outline-none"
                id="name"
                type="text"
                name="name"
                onChange={(e) => setData('name', e.target.value)}
              />
            </fieldset>
            <fieldset className="flex w-full flex-col gap-1">
              <label htmlFor="trait">Personality trait</label>
              <input
                required
                value={data.trait}
                className="max-w-96 rounded-sm bg-white px-2 py-1 ring ring-black/20 focus:ring-2 focus:ring-cyan-500 focus:outline-none"
                id="trait"
                type="text"
                name="trait"
                onChange={(e) => setData('trait', e.target.value)}
              />
            </fieldset>
            <fieldset
              className="col-span-2 flex w-full flex-col gap-1"
            >
              <label htmlFor="image">Profile pic</label>
              <input
                className="max-w-96 rounded-sm bg-white px-2 py-1 ring ring-black/20 focus:ring-2 focus:ring-cyan-500 focus:outline-none"
                id="image"
                type="file"
                name="image"
                required
                onChange={(e) => setData('image', e.target.files ? e.target.files[0] : null)}
              />
            </fieldset>
          </div>
          <SubmitButton />
        </Form>
    </div>
  )
}

function SubmitButton() {
  const status = useFormStatus()

  return (
    <button
      className="mt-4 inline-block rounded bg-cyan-300 px-4 py-2 font-medium text-cyan-900 hover:bg-cyan-200 focus:ring-2 focus:ring-cyan-500 focus:outline-none disabled:cursor-not-allowed disabled:bg-slate-200"
      type="submit"
      disabled={status.pending}
    >
      {status.pending ? `Adding ${status?.data?.get('name') || 'puppy'}...` : 'Add puppy'}
    </button>
  )
}
