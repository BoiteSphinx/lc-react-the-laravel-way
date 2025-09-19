import { Heart, LoaderCircle } from "lucide-react";
import { Puppy, SharedData } from "../types";
import { Form, Link, usePage } from "@inertiajs/react";
import { like } from '@/routes/puppies'
import clsx from "clsx";

export function LikeToggle({ puppy }: {
  puppy: Puppy;
}) {
  const { auth } = usePage<SharedData>().props

  return (
    <Form
      method="patch"
      action={like(puppy.id)}
      options={{
        preserveScroll: true,
      }}
    >
      {({ processing }) => (
        <button
          className={clsx('group', !auth.user && 'cursor-not-allowed')}
          disabled={!auth.user || processing}
          type="submit"
        >
          {processing ? (
            <LoaderCircle className="animate-spin stroke-slate-300" />
          ) : (
            <Heart
              className={clsx(
                auth.user && puppy.likedBy.includes(auth.user.id)
                ? 'fill-pink-500 stroke-none'
                : 'stroke-slate-200 group-hover:stroke-slate-300',
              )}
            />
          )}
        </button>
      )}
    </Form>
  )
}
