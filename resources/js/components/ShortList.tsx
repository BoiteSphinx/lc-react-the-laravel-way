import { Heart, LoaderCircle, X } from "lucide-react";
import { Puppy, SharedData } from "../types";
import { Form, usePage } from "@inertiajs/react";
import { like } from "@/routes/puppies";

export function ShortList({ puppies }: { puppies: Puppy[]; }) {
  const firstFivePuppies = puppies.slice(0, 5)
  const extraPuppiesCount = puppies.length - firstFivePuppies.length

  return (
    <div>
      <h2 className="flex items-center gap-2 font-medium">
        <span>Your shortlist</span>
        <Heart className="fill-pink-500 stroke-none" />
      </h2>
      <ul className="mt-4 flex flex-wrap gap-4">
        {firstFivePuppies.map((puppy) => (
          <li key={puppy.id} className="relative flex items-center overflow-clip rounded-md bg-white shadow-sm ring ring-black/5 transition duration-100 starting:scale-0 starting:opacity-0">
            <img
              height={32}
              width={32}
              alt={puppy.name}
              className="aspect-square w-8 object-cover"
              src={puppy.imageUrl}
            />
            <p className="px-3 text-sm text-slate-800">{puppy.name}</p>
            <DeleteButton id={puppy.id} />
          </li>
        ))}
        {extraPuppiesCount > 0 && (
          <li className="text-sm text-slate-800 self-center">+{extraPuppiesCount} more</li>
        )}
      </ul>
    </div>
  )
}

function DeleteButton({ id }: { id: Puppy['id'] }) {
  return (
    <Form
      method="patch"
      action={like(id)}
      options={{
        preserveScroll: true,
      }}
      className="h-full"
    >
      {({ processing }) => (
        <button type="submit" className="group h-full border-l border-slate-100 px-2 hover:bg-slate-100" disabled={processing}>
          {processing ? (
            <LoaderCircle className="size-4 animate-spin stroke-slate-300" />
          ) : (
            <X className="size-4 stroke-slate-400 group-hover:stroke-red-400" />
          )}
        </button>
      )}
    </Form>
  )
}
